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
    // public function createOrder(Request $request)
    // {
    //     $api = new Api(
    //         config('services.razorpay.key'),
    //         config('services.razorpay.secret')
    //     );

    //     $amount = 1 * 100; // ₹500

    //     $order = $api->order->create([
    //         'amount' => $amount,
    //         'currency' => 'INR',
    //         'receipt' => 'lead_'.$request->cust_id,
    //     ]);

    //     return response()->json([
    //         'order_id' => $order['id'],
    //         'amount' => $amount,
    //         'key' => config('services.razorpay.key')
    //     ]);
    // }
    public function createOrder(Request $request)
{
    $request->validate([
        'cust_id' => 'required'
    ]);

    $api = new Api(
        config('services.razorpay.key'),
        config('services.razorpay.secret')
    );

    $amount = 1 * 100; // ✅ ₹1 ONLY

    $order = $api->order->create([
        'amount'   => $amount,
        'currency' => 'INR',
        'receipt'  => 'lead_'.$request->cust_id,
        'notes' => [
            'purpose' => 'Lead Unlock ₹1',
            'platform' => 'ConstructKaro'
        ]
    ]);

    return response()->json([
        'success'   => true,
        'order_id' => $order['id'],
        'amount'   => $amount,
        'key'      => config('services.razorpay.key')
    ]);
}


    /* ================= VERIFY PAYMENT ================= */
    public function verifyPayment(Request $request)
    {
        $api = new Api(
            config('services.razorpay.key'),
            config('services.razorpay.secret')
        );

        try {
            $api->utility->verifyPaymentSignature([
                'razorpay_order_id'   => $request->razorpay_order_id,
                'razorpay_payment_id' => $request->razorpay_payment_id,
                'razorpay_signature'  => $request->razorpay_signature,
            ]);

            // ✅ Save payment
            // Payment::create([
            //     'payment_id' => $request->razorpay_payment_id,
            //     'order_id'   => $request->razorpay_order_id,
            //     'amount'     => 500,
            //     'status'     => 'success',
            //     'login_id'   => Session::get('user_id'),
            //     'user_id'    => base64_decode($request->cust_id),
            // ]);
            Payment::create([
                'payment_id' => $request->razorpay_payment_id,
                'order_id'   => $request->razorpay_order_id,
                'amount'     => 1, // ✅ ₹1
                'currency'   => 'INR',
                'status'     => 'success',
                'login_id'   => Session::get('user_id'),
                'user_id'    => base64_decode($request->cust_id),
                'response'   => json_encode($request->all())
            ]);


            return response()->json(['success' => true]);

        } catch (\Exception $e) {

            Log::error($e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Payment verification failed'
            ], 400);
        }
    }
 



}
