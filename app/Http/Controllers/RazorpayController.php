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
    //     $c = $request->c; // customer flag
    //     $v = $request->v; // vendor flag

    //     // decide flag
    //     $flag = null;
    //     if ($c) {
    //         $flag = 'c';
    //     } elseif ($v) {
    //         $flag = 'v';
    //     }
    //     dd($flag);
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
    //             'flag'       => $flag,
    //             'status'     => 'success',
    //             'login_id'   => Session::get('user_id'),
    //             'user_id'    => base64_decode($request->cust_id),
    //             'response'   => json_encode($request->all())
    //         ]);

    //         // 2️⃣ Add logic depending on the flag
    //         // if ($flag === 'v') {
    //         //     // Add leads to vendor
    //         //     $planLeads = [
    //         //         'single'  => 1,
    //         //         'starter' => 10,
    //         //         'grow'    => 25
    //         //     ];

    //         //     $leadsToAdd = $planLeads[$request->plan] ?? 0;

    //         //     DB::table('vendor_reg')
    //         //         ->where('id', Session::get('vendor_id'))
    //         //         ->increment('lead_balance', $leadsToAdd);

    //         // }
    //          if ($flag === 'v') {

    //             // ✅ plan => credits mapping (as per your subscription page)
    //             $planCredits = [
    //                 'trial'   => 30,   // ₹199
    //                 'starter' => 70,   // ₹399
    //                 'builder' => 160,  // ₹799
    //                 'pro'     => 320,  // ₹1499
    //                 'power'   => 700,  // ₹2999
    //             ];

    //             $creditsToAdd = $planCredits[$request->plan] ?? 0;

    //             if ($creditsToAdd <= 0) {
    //                 DB::rollBack();
    //                 return response()->json([
    //                     'success' => false,
    //                     'message' => 'Invalid plan selected'
    //                 ], 422);
    //             }

    //             // ✅ Add credits to vendor wallet (lead_balance is treated as credits)
    //             DB::table('vendor_reg')
    //                 ->where('id', Session::get('vendor_id'))
    //                 ->increment('lead_balance', $creditsToAdd);

    //             // ✅ OPTIONAL (Recommended): Store credits in Payment table too
    //             Payment::where('payment_id', $request->razorpay_payment_id)
    //                 ->update([
    //                     'plan'           => $request->plan,
    //                     'credits_added'  => $creditsToAdd,
    //                 ]);
    //         }elseif ($flag === 'c') {
    //             // Increment subscription_count in users table for the customer
    //             DB::table('users')
    //                 ->where('id', base64_decode($request->cust_id))
    //                 ->increment('subscription_count', 1);
    //         }

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
    // ✅ detect flag from session (most reliable)
    $flag = Session::has('vendor_id') ? 'v' : (Session::get('customer_id') ? 'c' : null);
    // dd(Session::has('vendor_id') );
    $loginId = null;

    if ($flag === 'v') {
        $loginId = Session::get('vendor_id');   // ✅ vendor logged-in id
    } elseif ($flag === 'c') {
        $loginId = Session::get('customer_id');     // ✅ customer logged-in id
    }
    // dd($loginId);
    if (!$flag) {
        return response()->json([
            'success' => false,
            'message' => 'Unauthorized / session missing'
        ], 401);
    }

    $api = new Api(config('services.razorpay.key'), config('services.razorpay.secret'));

   
        $api->utility->verifyPaymentSignature([
            'razorpay_order_id'   => $request->razorpay_order_id,
            'razorpay_payment_id' => $request->razorpay_payment_id,
            'razorpay_signature'  => $request->razorpay_signature,
        ]);

        DB::beginTransaction();

        // Save payment
        Payment::create([
            'payment_id' => $request->razorpay_payment_id,
            'order_id'   => $request->razorpay_order_id,
            'amount'     => $request->amount,
            'currency'   => 'INR',
            'flag'       => $flag,
            'status'     => 'success',
            'login_id'   => $loginId,
            'user_id'    => $loginId,
            'response'   => json_encode($request->all()),
            'plan'       => $request->plan ?? null,
        ]);

        if ($flag === 'v') {

            $planCredits = [
                'trial'   => 30,
                'starter' => 70,
                'builder' => 160,
                'pro'     => 320,
                'power'   => 700,
            ];
// dd($planCredits);
            $creditsToAdd = $planCredits[$request->plan] ?? 0;

            if ($creditsToAdd <= 0) {
                DB::rollBack();
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid plan selected'
                ], 422);
            }

            DB::table('vendor_reg')
                ->where('id', Session::get('vendor_id'))
                ->increment('lead_balance', $creditsToAdd);

            // optional store credits
            Payment::where('payment_id', $request->razorpay_payment_id)
                ->update(['credits_added' => $creditsToAdd]);

        } else {
            DB::table('users')
                ->where('id', base64_decode($request->cust_id))
                ->increment('subscription_count', 1);
        }

        DB::commit();

        return response()->json(['success' => true]);

    
}


}
