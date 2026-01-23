<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Razorpay\Api\Api;
use App\Models\Payment;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class RazorpayController extends Controller
{
   
   
    public function createOrder(Request $request)
    {
        $request->validate([
            'cust_id' => 'required',
            'plan'    => 'required',
            'amount'  => 'required|numeric'
        ]);

        $api = new Api(
            config('services.razorpay.key'),
            config('services.razorpay.secret')
        );

        $amount = $request->amount * 100;
        //  $amount =1;
        // dd($amount);
        //   $amount =0;
        $order = $api->order->create([
            'amount'   => $amount,
            'currency' => 'INR',
            'receipt'  => 'lead_'.$request->cust_id,
            'notes' => [
                'plan'     => $request->plan,
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
  
    // public function verifyPayment(Request $request)
    // {
    //     // dd($request);
    //     $c = $request->c; // customer flag
    //     $v = $request->v; // vendor flag

    //      // decide flag
    //     $flag = null;
    //     if ($c) {
    //         $flag = 'c';
    //     } elseif ($v) {
    //         $flag = 'v';
    //     }
    //     // dd($request);
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

    //         // 1️⃣ Save payment
    //         Payment::create([
    //             'payment_id' => $request->razorpay_payment_id,
    //             'order_id'   => $request->razorpay_order_id,
    //             'amount'     => $request->amount,
    //             'currency'   => 'INR',
    //             'flag'       =>$flag,
    //             'status'     => 'success',
    //             'login_id'   => Session::get('user_id'),
    //             'user_id'    => base64_decode($request->cust_id),
    //             'response'   => json_encode($request->all())
    //         ]);

            
    //         // 2️⃣ Calculate leads to add
    //         $planLeads = [
    //             'single'  => 1,
    //             'starter' => 10,
    //             'grow'    => 25
    //         ];

    //         $leadsToAdd = $planLeads[$request->plan] ?? 0;

    //         // 3️⃣ ADD LEADS TO VENDOR
    //         DB::table('vendor_reg')
    //             ->where('id', Session::get('vendor_id'))
    //             ->increment('lead_balance', $leadsToAdd);

    //         DB::commit();

    //         return response()->json(['success' => true]);

    //     } catch (\Exception $e) {
    //         DB::rollBack();
    //         Log::error($e->getMessage());

    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Payment verification failed'
    //         ], 400);
    //     }
    // }

public function verifyPayment(Request $request)
{
    $c = $request->c; // customer flag
    $v = $request->v; // vendor flag

    // decide flag
    $flag = null;
    if ($c) {
        $flag = 'c';
    } elseif ($v) {
        $flag = 'v';
    }

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

        DB::beginTransaction();

        // 1️⃣ Save payment
        Payment::create([
            'payment_id' => $request->razorpay_payment_id,
            'order_id'   => $request->razorpay_order_id,
            'amount'     => $request->amount,
            'currency'   => 'INR',
            'flag'       => $flag,
            'status'     => 'success',
            'login_id'   => Session::get('user_id'),
            'user_id'    => base64_decode($request->cust_id),
            'response'   => json_encode($request->all())
        ]);

        // 2️⃣ Add logic depending on the flag
        if ($flag === 'v') {
            // Add leads to vendor
            $planLeads = [
                'single'  => 1,
                'starter' => 10,
                'grow'    => 25
            ];

            $leadsToAdd = $planLeads[$request->plan] ?? 0;

            DB::table('vendor_reg')
                ->where('id', Session::get('vendor_id'))
                ->increment('lead_balance', $leadsToAdd);

        } elseif ($flag === 'c') {
            // Increment subscription_count in users table for the customer
            DB::table('users')
                ->where('id', base64_decode($request->cust_id))
                ->increment('subscription_count', 1);
        }

        DB::commit();

        return response()->json(['success' => true]);

    } catch (\Exception $e) {
        DB::rollBack();
        Log::error($e->getMessage());

        return response()->json([
            'success' => false,
            'message' => 'Payment verification failed'
        ], 400);
    }
}


}
