<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Razorpay\Api\Api;
use App\Models\Payment;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Session;

class RazorpayController extends Controller
{
   
  
    public function createOrder(Request $request)
    {
        $request->validate([
            'cust_id' => 'required',
            'plan'    => 'required',
            'amount'  => 'required|numeric|min:1'
        ]);

        $api = new Api(
            config('services.razorpay.key'),
            config('services.razorpay.secret')
        );

        
        $baseAmount = (float) $request->amount;
        $gstRate    = 18;

        $gstAmount  = round(($baseAmount * $gstRate) / 100, 2);
        $totalAmount = round($baseAmount + $gstAmount, 2);

      
        $razorAmount = (int) round($totalAmount * 100);

        $order = $api->order->create([
            'amount'   => $razorAmount,
            'currency' => 'INR',
            'receipt'  => 'lead_' . $request->cust_id,
            'notes' => [
                'plan'         => $request->plan,
                'platform'     => 'ConstructKaro',
                'base_amount'  => $baseAmount,
                'gst_18%'      => $gstAmount,
                'total_amount' => $totalAmount,
            ]
        ]);

        return response()->json([
            'success'       => true,
            'order_id'      => $order['id'],
            'base_amount'   => $baseAmount,
            'gst_amount'    => $gstAmount,
            'total_amount'  => $totalAmount,
            'razor_amount'  => $razorAmount,
            'key'           => config('services.razorpay.key')
        ]);
    }

   
    // public function verifyPayment(Request $request)
    // {
    //     $request->validate([
    //         'razorpay_order_id'   => 'required',
    //         'razorpay_payment_id' => 'required',
    //         'razorpay_signature'  => 'required',
    //         'amount'              => 'required|numeric',
    //         'plan'                => 'required'
    //     ]);

    //     $flag = Session::has('vendor_id') ? 'v' :
    //         (Session::has('customer_id') ? 'c' : null);

    //     if (!$flag) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Unauthorized session'
    //         ], 401);
    //     }

    //     $loginId = $flag === 'v'
    //         ? Session::get('vendor_id')
    //         : Session::get('customer_id');

    //     $api = new Api(
    //         config('services.razorpay.key'),
    //         config('services.razorpay.secret')
    //     );

    //     try {

    //         $api->utility->verifyPaymentSignature([
    //             'razorpay_order_id'   => $request->razorpay_order_id,
    //             'razorpay_payment_id' => $request->razorpay_payment_id,
    //             'razorpay_signature'  => $request->razorpay_signature,
    //         ]);

    //         DB::beginTransaction();

    //         $baseAmount = (float) $request->amount;
    //         $gstAmount  = round(($baseAmount * 18) / 100, 2);
    //         $totalAmount = round($baseAmount + $gstAmount, 2);

    //         $payment = Payment::create([
    //             'payment_id'  => $request->razorpay_payment_id,
    //             'order_id'    => $request->razorpay_order_id,
    //             'base_amount' => $baseAmount,
    //             'gst_amount'  => $gstAmount,
    //             'amount'      => $totalAmount,
    //             'currency'    => 'INR',
    //             'flag'        => $flag,
    //             'status'      => 'success',
    //             'login_id'    => $loginId,
    //             'user_id'     => $loginId,
    //             'response'    => json_encode($request->all()),
    //             'plan'        => $request->plan,
    //         ]);

    //         if ($flag === 'v') {

    //             $planCredits = [
    //                 'trial'   => 30,
    //                 'starter' => 70,
    //                 'builder' => 160,
    //                 'pro'     => 320,
    //                 'power'   => 700,
    //             ];

    //             $creditsToAdd = $planCredits[$request->plan] ?? 0;

    //             if ($creditsToAdd <= 0) {
    //                 DB::rollBack();
    //                 return response()->json([
    //                     'success' => false,
    //                     'message' => 'Invalid plan selected'
    //                 ], 422);
    //             }

    //             DB::table('vendor_reg')
    //                 ->where('id', $loginId)
    //                 ->increment('lead_balance', $creditsToAdd);

    //             $payment->update([
    //                 'credits_added' => $creditsToAdd
    //             ]);
    //         }

    //         else {

    //             DB::table('users')
    //                 ->where('id', $loginId)
    //                 ->increment('subscription_count', 1);
    //         }

    //         DB::commit();

    //         return response()->json([
    //             'success' => true,
    //             'invoice_url' => route('invoice.download',$request->razorpay_payment_id)

    //         ]);

    //     } catch (\Exception $e) {

    //         DB::rollBack();

    //         return response()->json([
    //             'success' => false,
    //             'message' => $e->getMessage()
    //         ], 500);
    //     }
    // }
    public function verifyPayment(Request $request)
{
    // dd($request);
    $request->validate([
        'razorpay_order_id'   => 'required',
        'razorpay_payment_id' => 'required',
        'razorpay_signature'  => 'required',
        'amount'              => 'required|numeric',
        'plan'                => 'required'
    ]);

    $flag = Session::has('vendor_id') ? 'v' : (Session::has('customer_id') ? 'c' : null);

    if (!$flag) {
        return response()->json([
            'success' => false,
            'message' => 'Unauthorized session'
        ], 401);
    }

    $loginId = $flag === 'v' ? Session::get('vendor_id') : Session::get('customer_id');

    $api = new Api(
        config('services.razorpay.key'),
        config('services.razorpay.secret')
    );

    // Verify payment signature
    $api->utility->verifyPaymentSignature([
        'razorpay_order_id'   => $request->razorpay_order_id,
        'razorpay_payment_id' => $request->razorpay_payment_id,
        'razorpay_signature'  => $request->razorpay_signature,
    ]);

    // Begin DB transaction
    DB::beginTransaction();

    $baseAmount = (float) $request->amount;
    $gstAmount  = round(($baseAmount * 18) / 100, 2);
    $totalAmount = round($baseAmount + $gstAmount, 2);

    $payment = Payment::create([
        'payment_id'  => $request->razorpay_payment_id,
        'order_id'    => $request->razorpay_order_id,
        'base_amount' => $baseAmount,
        'gst_amount'  => $gstAmount,
        'amount'      => $totalAmount,
        'currency'    => 'INR',
        'flag'        => $flag,
        'status'      => 'success',
        'login_id'    => $loginId,
        'user_id'     => $loginId,
        'response'    => json_encode($request->all()),
        'plan'        => $request->plan,
    ]);

    if ($flag === 'v') {
        $planCredits = [
            'trial'   => 30,
            'starter' => 70,
            'builder' => 160,
            'pro'     => 320,
            'power'   => 700,
        ];

        $creditsToAdd = $planCredits[$request->plan] ?? 0;

        if ($creditsToAdd <= 0) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Invalid plan selected'
            ], 422);
        }

        DB::table('vendor_reg')
            ->where('id', $loginId)
            ->increment('lead_balance', $creditsToAdd);

        $payment->update([
            'credits_added' => $creditsToAdd
        ]);
    } else {
        DB::table('users')
            ->where('id', $loginId)
            ->increment('subscription_count', 1);
    }

    DB::commit();

    return response()->json([
        'success' => true,
        'invoice_url' => route('invoice.download', $request->razorpay_payment_id)
    ]);
}

    public function downloadInvoice($paymentId)
{
    // dd($paymentId);
    $payment = Payment::where('payment_id',$paymentId)->firstOrFail();

    $pdf = Pdf::loadView('invoice.payment_invoice',[
        'payment'=>$payment
    ]);

    return $pdf->download('invoice-'.$payment->payment_id.'.pdf');
}

}
