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
    public function createOrder(Request $request)
    {
        $api = new Api(
            config('services.razorpay.key'),
            config('services.razorpay.secret')
        );

        $amount = 1 * 100; // ₹500

        $order = $api->order->create([
            'amount' => $amount,
            'currency' => 'INR',
            'receipt' => 'lead_'.$request->cust_id,
        ]);

        return response()->json([
            'order_id' => $order['id'],
            'amount' => $amount,
            'key' => config('services.razorpay.key')
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
            Payment::create([
                'payment_id' => $request->razorpay_payment_id,
                'order_id'   => $request->razorpay_order_id,
                'amount'     => 500,
                'status'     => 'success',
                'login_id'   => Session::get('user_id'),
                'user_id'    => base64_decode($request->cust_id),
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
 
//     public function showPaymentForm(Request $request)
//     {
//         $displayAmount = 500; 
//         $razorpayAmount = 500 * 100;
        
//         // Decrypt vendor ID
//         $vendor_id = null;
//         if ($request->has('vendor_id')) {
//             try {
//                 $vendor_id = base64_decode($request->vendor_id);
//             } catch (\Exception $e) {
//                 return redirect()->route('search_vendor')->with('error', 'Invalid vendor selected!');
//             }
//         }

//         return view('payments.razorpay', [
//             'displayAmount' => $displayAmount,
//             'amount' => $razorpayAmount,
//             'razorpayKey' => config('services.razorpay.key'),
//             'vendor_id' => $vendor_id,
//         ]);
//     }

//     public function handlePayment(Request $request)
//     {
        
//         $input = $request->all();

//         $api = new Api(config('services.razorpay.key'), config('services.razorpay.secret'));

//         try {
//             if (!isset($input['razorpay_payment_id'])) {
//                 Payment::create([
//                     'login_id' => Session::get('user_id'),
//                     'user_id' => base64_decode($request->vendor_id),
//                     'amount' => $request->amount / 100,
//                     'status' => 'failed',
//                     'response' => json_encode($input)
//                 ]);

//                 return back()->with('error', 'Payment failed! Payment ID missing.');
//             }

//             // Fetch Razorpay payment info
//             $payment = $api->payment->fetch($input['razorpay_payment_id']);

//             // Convert back to ₹
//             $paidAmount = $payment['amount'] / 100;

//             Payment::create([
//                 'payment_id' => $payment['id'],
//                 'order_id' => $payment['order_id'] ?? null,
//                 'amount' => $paidAmount,
//                 'currency' => $payment['currency'],
//                 'status' => $payment['status'],
//                 'login_id' =>  Session::get('user_id'),
//                 'user_id' => base64_decode($request->vendor_id),
//                 'customer_email' => $payment['email'] ?? null,
//                 'customer_contact' => $payment['contact'] ?? null,
//                 'response' => json_encode($payment)
//             ]);

//             // return redirect()
//             //     ->route('search_vendor')
//             //     ->with('success', 'Payment Successful! Vendor contact unlocked.');
//             return response()->json([
//         'status' => 'success',
//         'message' => 'Payment successful'
//     ]);


//         } catch (\Exception $e) {

//             Payment::create([
//                 'login_id' =>  Session::get('user_id'),
//                 'user_id' => base64_decode($request->vendor_id),
//                 'amount' => $request->amount / 100,
//                 'status' => 'failed',
//                 'response' => json_encode(['error' => $e->getMessage()])
//             ]);

//             // return redirect()
//             //     ->route('search_vendor')
//             //     ->with('error', 'Payment failed: '.$e->getMessage());
//             return response()->json([
//     'status' => 'error',
//     'message' => 'Payment failed'
// ], 500);

//         }
//     }



}
