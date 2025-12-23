<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Razorpay\Api\Api;
use App\Models\Payment;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

use Illuminate\Support\Facades\Session;

class RazorpayController extends Controller
{
 
    public function showPaymentForm(Request $request)
    {
        $displayAmount = 500; 
        $razorpayAmount = 500 * 100;
        
        // Decrypt vendor ID
        $vendor_id = null;
        if ($request->has('vendor_id')) {
            try {
                $vendor_id = base64_decode($request->vendor_id);
            } catch (\Exception $e) {
                return redirect()->route('search_vendor')->with('error', 'Invalid vendor selected!');
            }
        }

        return view('payments.razorpay', [
            'displayAmount' => $displayAmount,
            'amount' => $razorpayAmount,
            'razorpayKey' => config('services.razorpay.key'),
            'vendor_id' => $vendor_id,
        ]);
    }

    public function handlePayment(Request $request)
    {
        
        $input = $request->all();

        $api = new Api(config('services.razorpay.key'), config('services.razorpay.secret'));

        try {
            if (!isset($input['razorpay_payment_id'])) {
                Payment::create([
                    'login_id' => Session::get('user_id'),
                    'user_id' => base64_decode($request->vendor_id),
                    'amount' => $request->amount / 100,
                    'status' => 'failed',
                    'response' => json_encode($input)
                ]);

                return back()->with('error', 'Payment failed! Payment ID missing.');
            }

            // Fetch Razorpay payment info
            $payment = $api->payment->fetch($input['razorpay_payment_id']);

            // Convert back to ₹
            $paidAmount = $payment['amount'] / 100;

            Payment::create([
                'payment_id' => $payment['id'],
                'order_id' => $payment['order_id'] ?? null,
                'amount' => $paidAmount,
                'currency' => $payment['currency'],
                'status' => $payment['status'],
                'login_id' =>  Session::get('user_id'),
                'user_id' => base64_decode($request->vendor_id),
                'customer_email' => $payment['email'] ?? null,
                'customer_contact' => $payment['contact'] ?? null,
                'response' => json_encode($payment)
            ]);

            return redirect()
                ->route('search_vendor')
                ->with('success', 'Payment Successful! Vendor contact unlocked.');

        } catch (\Exception $e) {

            Payment::create([
                'login_id' =>  Session::get('user_id'),
                'user_id' => base64_decode($request->vendor_id),
                'amount' => $request->amount / 100,
                'status' => 'failed',
                'response' => json_encode(['error' => $e->getMessage()])
            ]);

            return redirect()
                ->route('search_vendor')
                ->with('error', 'Payment failed: '.$e->getMessage());
        }
    }

}
