<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Razorpay\Api\Api;
use App\Models\Payment;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class RazorpayController extends Controller
{
    public function createOrder(Request $request)
    {
       
        $request->validate([
            'cust_id' => 'required',
            'plan'    => 'required',
            'amount'  => 'required|numeric|min:1',
        ]);

        $api = new Api(
            config('services.razorpay.key'),
            config('services.razorpay.secret')
        );

        // $baseAmount  = (float) $request->amount;
        $baseAmount  = 1;
        $gstRate     = 18;
        $gstAmount   = round(($baseAmount * $gstRate) / 100, 2);
        $totalAmount = round($baseAmount + $gstAmount, 2);
        $razorAmount = (int) round($totalAmount * 100);
 dd($razorAmount);
        $order = $api->order->create([
            'amount'   => $razorAmount,
            'currency' => 'INR',
            'receipt'  => 'lead_' . $request->cust_id . '_' . time(),
            'notes'    => [
                'plan'         => $request->plan,
                'platform'     => 'ConstructKaro',
                'base_amount'  => $baseAmount,
                'gst_18'       => $gstAmount,
                'total_amount' => $totalAmount,
            ],
        ]);

        return response()->json([
            'success'      => true,
            'order_id'     => $order['id'],
            'base_amount'  => $baseAmount,
            'gst_amount'   => $gstAmount,
            'total_amount' => $totalAmount,
            'razor_amount' => $razorAmount,
            'key'          => config('services.razorpay.key'),
        ]);
    }

    public function verifyPayment(Request $request)
    {
        $request->validate([
            'razorpay_order_id'   => 'required|string',
            'razorpay_payment_id' => 'required|string',
            'razorpay_signature'  => 'required|string',
            'amount'              => 'required|numeric|min:1',
            'plan'                => 'required|string',
        ]);

        $flag = Session::has('vendor_id') ? 'v' : (Session::has('customer_id') ? 'c' : null);

        if (!$flag) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized session',
            ], 401);
        }

        $loginId = $flag === 'v'
            ? Session::get('vendor_id')
            : Session::get('customer_id');

        $api = new Api(
            config('services.razorpay.key'),
            config('services.razorpay.secret')
        );

        // Razorpay signature verify
        $api->utility->verifyPaymentSignature([
            'razorpay_order_id'   => $request->razorpay_order_id,
            'razorpay_payment_id' => $request->razorpay_payment_id,
            'razorpay_signature'  => $request->razorpay_signature,
        ]);

        // already paid check
        $existingPayment = Payment::where('payment_id', $request->razorpay_payment_id)->first();
        if ($existingPayment) {
            return response()->json([
                'success'     => true,
                'message'     => 'Payment already verified',
                'invoice_url' => route('invoice.download', $existingPayment->payment_id),
            ]);
        }

        $baseAmount  = (float) $request->amount;
        $gstAmount   = round(($baseAmount * 18) / 100, 2);
        $totalAmount = round($baseAmount + $gstAmount, 2);

        $planCredits = [
            'trial'   => 30,
            'starter' => 70,
            'builder' => 160,
            'pro'     => 320,
            'power'   => 700,
        ];

        $creditsToAdd = $planCredits[$request->plan] ?? 0;

        if ($flag === 'v' && $creditsToAdd <= 0) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid plan selected',
            ], 422);
        }

        $payment = DB::transaction(function () use (
            $request,
            $flag,
            $loginId,
            $baseAmount,
            $gstAmount,
            $totalAmount,
            $creditsToAdd
        ) {
            $payment = Payment::create([
                'payment_id'     => $request->razorpay_payment_id,
                'order_id'       => $request->razorpay_order_id,
                'base_amount'    => $baseAmount,
                'gst_amount'     => $gstAmount,
                'amount'         => $totalAmount,
                'currency'       => 'INR',
                'status'         => 'success',
                'response'       => json_encode($request->all()),
                'plan'           => $request->plan,
                'payment_method' => 'Razorpay',
                'invoice_date'   => now()->toDateString(),
                'user_id'        => (string) $loginId,
                'login_id'       => $loginId,
                'flag'           => $flag,
                'credits_added'  => $flag === 'v' ? $creditsToAdd : null,
            ]);

            if ($flag === 'v') {
                DB::table('vendor_reg')
                    ->where('id', $loginId)
                    ->increment('lead_balance', $creditsToAdd);
            } else {
                DB::table('users')
                    ->where('id', $loginId)
                    ->increment('subscription_count', 1);
            }

            $invoiceNo = 'INV-' . date('Ymd') . '-' . str_pad($payment->id, 5, '0', STR_PAD_LEFT);

            $pdf = Pdf::loadView('invoice.payment_invoice', [
                'payment'   => $payment,
                'invoiceNo' => $invoiceNo,
            ]);

            $folderPath = 'invoices/' . date('Y/m');
            $fileName   = 'invoice-' . $payment->payment_id . '.pdf';
            $filePath   = $folderPath . '/' . $fileName;

            Storage::disk('public')->put($filePath, $pdf->output());

            $payment->update([
                'invoice_no'   => $invoiceNo,
                'invoice_path' => $filePath,
            ]);

            return $payment->fresh();
        });

        return response()->json([
            'success'     => true,
            'message'     => 'Payment verified successfully',
            'invoice_url' => route('invoice.download', $payment->payment_id),
        ]);
    }

    public function downloadInvoice($paymentId)
    {
        $payment = Payment::where('payment_id', $paymentId)->firstOrFail();

        if ($payment->invoice_path && Storage::disk('public')->exists($payment->invoice_path)) {
            return Storage::disk('public')->download(
                $payment->invoice_path,
                'invoice-' . $payment->payment_id . '.pdf'
            );
        }

        $invoiceNo = $payment->invoice_no ?: 'INV-' . date('Ymd') . '-' . str_pad($payment->id, 5, '0', STR_PAD_LEFT);

        $pdf = Pdf::loadView('invoice.payment_invoice', [
            'payment'   => $payment,
            'invoiceNo' => $invoiceNo,
        ]);

        $folderPath = 'invoices/' . date('Y/m');
        $fileName   = 'invoice-' . $payment->payment_id . '.pdf';
        $filePath   = $folderPath . '/' . $fileName;

        Storage::disk('public')->put($filePath, $pdf->output());

        $payment->update([
            'invoice_no'     => $invoiceNo,
            'invoice_path'   => $filePath,
            'invoice_date'   => $payment->invoice_date ?: now()->toDateString(),
            'payment_method' => $payment->payment_method ?: 'Razorpay',
        ]);

        return Storage::disk('public')->download(
            $filePath,
            'invoice-' . $payment->payment_id . '.pdf'
        );
    }
}