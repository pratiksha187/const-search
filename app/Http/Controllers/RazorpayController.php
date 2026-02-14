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
   
   
    // public function createOrder(Request $request)
    // {
    //     $request->validate([
    //         'cust_id' => 'required',
    //         'plan'    => 'required',
    //         'amount'  => 'required|numeric'
    //     ]);

    //     $api = new Api(
    //         config('services.razorpay.key'),
    //         config('services.razorpay.secret')
    //     );

    //     // $amount = $request->amount * 100;
    //     $baseAmount = $request->amount;

    //     $gstAmount  = ($baseAmount * 18) / 100; // 18% GST
    //     $totalAmount = $baseAmount + $gstAmount;

    //     // Razorpay expects paisa
    //     $amount = $totalAmount * 100;

    //     $order = $api->order->create([
    //         'amount'   => $amount,
    //         'currency' => 'INR',
    //         'receipt'  => 'lead_'.$request->cust_id,
    //         'notes' => [
    //             'plan'     => $request->plan,
    //             'platform' => 'ConstructKaro',
    //             'base_amount' => $baseAmount,
    //             'gst_18%'     => $gstAmount,
    //             'total'       => $totalAmount
    //         ]
    //     ]);

    //     return response()->json([
    //         'success'   => true,
    //         'order_id' => $order['id'],
    //         'base_amount'  => $baseAmount,
    //         'gst_amount'   => $gstAmount,
    //         'total_amount' => $totalAmount,
            
    //         'amount'   => $amount,
    //         'key'      => config('services.razorpay.key')
    //     ]);
    // }
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

    // ===============================
    // GST CALCULATION
    // ===============================
    $baseAmount = (float) $request->amount;
    $gstRate    = 18;

    $gstAmount  = round(($baseAmount * $gstRate) / 100, 2);
    $totalAmount = round($baseAmount + $gstAmount, 2);

    // Razorpay accepts amount in paisa
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
//     // ✅ detect flag from session (most reliable)
//     $flag = Session::has('vendor_id') ? 'v' : (Session::get('customer_id') ? 'c' : null);
//     // dd(Session::has('vendor_id') );
//     $loginId = null;

//     if ($flag === 'v') {
//         $loginId = Session::get('vendor_id');   // ✅ vendor logged-in id
//     } elseif ($flag === 'c') {
//         $loginId = Session::get('customer_id');     // ✅ customer logged-in id
//     }
//     // dd($loginId);
//     if (!$flag) {
//         return response()->json([
//             'success' => false,
//             'message' => 'Unauthorized / session missing'
//         ], 401);
//     }

//     $api = new Api(config('services.razorpay.key'), config('services.razorpay.secret'));

   
//         $api->utility->verifyPaymentSignature([
//             'razorpay_order_id'   => $request->razorpay_order_id,
//             'razorpay_payment_id' => $request->razorpay_payment_id,
//             'razorpay_signature'  => $request->razorpay_signature,
//         ]);

//         DB::beginTransaction();

//         // Save payment
//         Payment::create([
//             'payment_id' => $request->razorpay_payment_id,
//             'order_id'   => $request->razorpay_order_id,
//             'amount'     => $request->amount,
//             'currency'   => 'INR',
//             'flag'       => $flag,
//             'status'     => 'success',
//             'login_id'   => $loginId,
//             'user_id'    => $loginId,
//             'response'   => json_encode($request->all()),
//             'plan'       => $request->plan ?? null,
//         ]);

//         if ($flag === 'v') {

//             $planCredits = [
//                 'trial'   => 30,
//                 'starter' => 70,
//                 'builder' => 160,
//                 'pro'     => 320,
//                 'power'   => 700,
//             ];
//         // dd($planCredits);
//             $creditsToAdd = $planCredits[$request->plan] ?? 0;

//             if ($creditsToAdd <= 0) {
//                 DB::rollBack();
//                 return response()->json([
//                     'success' => false,
//                     'message' => 'Invalid plan selected'
//                 ], 422);
//             }

//             DB::table('vendor_reg')
//                 ->where('id', Session::get('vendor_id'))
//                 ->increment('lead_balance', $creditsToAdd);

//             // optional store credits
//             Payment::where('payment_id', $request->razorpay_payment_id)
//                 ->update(['credits_added' => $creditsToAdd]);

//         } else {
//             DB::table('users')
//                 ->where('id', base64_decode($request->cust_id))
//                 ->increment('subscription_count', 1);
//         }

//         DB::commit();

//         return response()->json(['success' => true]);

    
// }
public function verifyPayment(Request $request)
{
    $request->validate([
        'razorpay_order_id'   => 'required',
        'razorpay_payment_id' => 'required',
        'razorpay_signature'  => 'required',
        'amount'              => 'required|numeric',
        'plan'                => 'required'
    ]);

    // ===============================
    // Detect User Type
    // ===============================
    $flag = Session::has('vendor_id') ? 'v' :
           (Session::has('customer_id') ? 'c' : null);

    if (!$flag) {
        return response()->json([
            'success' => false,
            'message' => 'Unauthorized session'
        ], 401);
    }

    $loginId = $flag === 'v'
        ? Session::get('vendor_id')
        : Session::get('customer_id');

    $api = new Api(
        config('services.razorpay.key'),
        config('services.razorpay.secret')
    );

    try {

        // ===============================
        // Verify Signature
        // ===============================
        $api->utility->verifyPaymentSignature([
            'razorpay_order_id'   => $request->razorpay_order_id,
            'razorpay_payment_id' => $request->razorpay_payment_id,
            'razorpay_signature'  => $request->razorpay_signature,
        ]);

        DB::beginTransaction();

        // ===============================
        // GST Calculation
        // ===============================
        $baseAmount = (float) $request->amount;
        $gstAmount  = round(($baseAmount * 18) / 100, 2);
        $totalAmount = round($baseAmount + $gstAmount, 2);

        // ===============================
        // Save Payment
        // ===============================
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

        // ===============================
        // Vendor Credit Logic
        // ===============================
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
        }

        // ===============================
        // Customer Subscription Logic
        // ===============================
        else {

            DB::table('users')
                ->where('id', $loginId)
                ->increment('subscription_count', 1);
        }

        DB::commit();

        return response()->json([
            'success' => true
        ]);

    } catch (\Exception $e) {

        DB::rollBack();

        return response()->json([
            'success' => false,
            'message' => $e->getMessage()
        ], 500);
    }
}


}
