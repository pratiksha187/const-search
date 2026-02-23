<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Twilio\Rest\Client;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Cache;
use App\Helpers\ProfileCompletionHelper;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Mail\RegisterSuccessMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\HomeController;



class LoginRegController extends Controller
{

    public function login_register(){
       
        return view('web.login_register');
    }

  

    public function changePassword(Request $request)
    {
        $request->validate([
            'login'    => 'required',
            'password' => 'required|min:6',
            'role'     => 'required|in:customer,vendor,supplier'
        ]);

        $hashedPassword = Hash::make($request->password);

        if ($request->role === 'customer') {

            $updated = DB::table('users')
                ->where('email', $request->login)
                ->orWhere('mobile', $request->login)
                ->update(['password' => $hashedPassword]);

        } elseif ($request->role === 'vendor') {

            $updated = DB::table('vendor_reg')
                ->where('email', $request->login)
                ->orWhere('mobile', $request->login)
                ->update(['password' => $hashedPassword]);

        } elseif ($request->role === 'supplier')  { // 

            $updated = DB::table('supplier_reg')
                ->where('email', $request->login)
                ->orWhere('mobile', $request->login)
                ->update(['password' => $hashedPassword]);
        }

        if (!$updated) {
            return response()->json([
                'status' => false,
                'message' => ucfirst($request->role) . ' account not found'
            ]);
        }

        return response()->json([
            'status' => true,
            'message' => 'Password changed successfully'
        ]);
    }

     // ============================= REGISTER ============================
   
  
public function register(Request $request)
{
    $request->validate([
        'role'     => ['required', 'in:customer,vendor,supplier'],
        'name'     => ['required', 'string', 'max:255'],
        'mobile'   => ['required'],
        'email'    => ['required', 'email'],
        'password' => ['required', 'min:4']
    ]);

    /* ================= DUPLICATE CHECK ================= */

    if ($request->role === 'vendor') {
        $exists = DB::table('vendor_reg')
            ->where('mobile', $request->mobile)
            ->orWhere('email', $request->email)
            ->exists();

        if ($exists) {
            return response()->json([
                'status'  => false,
                'message' => 'Vendor already registered with this mobile or email'
            ]);
        }
    }

    if ($request->role === 'supplier') {
        $exists = DB::table('supplier_reg')
            ->where('mobile', $request->mobile)
            ->orWhere('email', $request->email)
            ->exists();

        if ($exists) {
            return response()->json([
                'status'  => false,
                'message' => 'Supplier already registered with this mobile or email'
            ]);
        }
    }

    if ($request->role === 'customer') {
        $exists = DB::table('users')
            ->where('mobile', $request->mobile)
            ->orWhere('email', $request->email)
            ->exists();

        if ($exists) {
            return response()->json([
                'status'  => false,
                'message' => 'Customer already registered with this mobile or email'
            ]);
        }
    }

    /* ================= ROLE BASE INSERT + SESSION ================= */
    $uid = null;
    $status = 'pending';

    // if ($request->role === 'vendor') {

    //     $vendorId = DB::table('vendor_reg')->insertGetId([
    //         'name'          => $request->name,
    //         'mobile'        => $request->mobile,
    //         'email'         => $request->email,
    //         'business_name' => $request->business_name ?? null,
    //         'gst_number'    => $request->gst_number ?? null,
    //         'status'        => $status,
    //         'password'      => Hash::make($request->password),
    //         'lead_balance'  => 150,
    //         'created_at'    => now(),
    //         'updated_at'    => now()
    //     ]);

    //     $uid = 'CKV-' . str_pad($vendorId, 6, '0', STR_PAD_LEFT);

    //     DB::table('vendor_reg')->where('id', $vendorId)->update([
    //         'vendor_uid' => $uid,
    //         'updated_at' => now(),
    //     ]);

    //     Session::put('vendor_id', $vendorId);
    // }
if ($request->role === 'vendor') {

    $expiryDate = now()->addDays(45);

    $vendorId = DB::table('vendor_reg')->insertGetId([
        'name'              => $request->name,
        'mobile'            => $request->mobile,
        'email'             => $request->email,
        'business_name'     => $request->business_name ?? null,
        'gst_number'        => $request->gst_number ?? null,
        'status'            => $status,
        'password'          => Hash::make($request->password),
        'lead_balance'      => 150,
        'credit_expiry_at'  => $expiryDate,
        'created_at'        => now(),
        'updated_at'        => now()
    ]);


    
    $uid = 'CKV-' . str_pad($vendorId, 6, '0', STR_PAD_LEFT);

    DB::table('vendor_reg')->where('id', $vendorId)->update([
        'vendor_uid' => $uid,
        'updated_at' => now(),
    ]);

    Session::put('vendor_id', $vendorId);
}
    elseif ($request->role === 'supplier') {

        $supplierId = DB::table('supplier_reg')->insertGetId([
            'shop_name'      => $request->shop_name ?? null,
            'contact_person' => $request->name,
            'mobile'         => $request->mobile,
            'email'          => $request->email,
            'status'         => $status,
            'password'       => Hash::make($request->password),
            'created_at'     => now(),
            'updated_at'     => now()
        ]);

        // Optional supplier UID if you want:
        // $uid = 'CKS-' . str_pad($supplierId, 6, '0', STR_PAD_LEFT);

        Session::put('supplier_id', $supplierId);
    }

    elseif ($request->role === 'customer') {

        $customerId = DB::table('users')->insertGetId([
            'name'       => $request->name,
            'mobile'     => $request->mobile,
            'email'      => $request->email,
            'role'       => $status,
            'password'   => Hash::make($request->password),
            'created_at' => now(),
            'updated_at' => now()
        ]);

        $uid = 'CKC-' . str_pad($customerId, 6, '0', STR_PAD_LEFT);

        DB::table('users')->where('id', $customerId)->update([
            'customer_uid' => $uid,
            'updated_at'   => now(),
        ]);

        Session::put('customer_id', $customerId);

        // keep your existing logic
        app(HomeController::class)->savePostFromSession();
    }

    /* ================= ✅ SEND EMAIL AFTER REGISTER ================= */
    try {
        if (!empty($request->email)) {
            Mail::to($request->email)->send(
                new RegisterSuccessMail([
                    'name'   => $request->name,
                    'role'   => $request->role,
                    'uid'    => $uid,
                    'status' => $status,
                ])
            );
        }
    } catch (\Throwable $e) {
        Log::error('Register email failed: ' . $e->getMessage());
    }
    // ✅ SEND WHATSAPP AFTER REGISTER (place here)
    // $this->sendWhatsAppAfterRegister(
    //     $request->mobile,
    //     $request->name,
    //     $request->role,
    //     $uid ?? null
    // );
    /* ================= REDIRECT ================= */
    $redirectUrl = match ($request->role) {
        'vendor'   => route('vendordashboard'),
        'supplier' => route('suppliers.profile'),
        'customer' => route('dashboard'),
    };

    return response()->json([
        'status'   => true,
        'message'  => ucfirst($request->role) . ' registration successful',
        'redirect' => $redirectUrl
    ]);
}
  

private function sendWhatsAppAfterRegister($mobile, $name, $role, $uid = null)
{
    try {
        // mobile -> +91XXXXXXXXXX
        $mobile = preg_replace('/\s+/', '', $mobile);
        if (!str_starts_with($mobile, '+')) {
            $mobile = '+91' . ltrim($mobile, '0');
        }

        $sid   = env('TWILIO_SID');
        $token = env('TWILIO_AUTH_TOKEN');
        $from  = env('TWILIO_WHATSAPP_FROM'); // whatsapp:+14155238886

        if (!$sid || !$token || !$from) return;

        $client = new Client($sid, $token);

        $msg = "Hi {$name} 👋\n"
             . "Welcome to ConstructKaro ✅\n"
             . "Your ".ucfirst($role)." registration is successful.\n"
             . ($uid ? "Your ID: {$uid}\n" : "")
             . "We will verify your profile shortly.\n\n"
             . "Team ConstructKaro";

        $client->messages->create(
            "whatsapp:{$mobile}",
            [
                'from' => $from,
                'body' => $msg,
            ]
        );

    } catch (\Throwable $e) {
        Log::error("WhatsApp send failed: " . $e->getMessage());
    }
}


    // ============================= LOGIN =============================
   
    public function login(Request $request)
    {
        $request->validate([
            'login'    => 'required',
            'password' => 'required',
            'role'     => 'required'
        ]);

        /* ======================================================
        ADMIN LOGIN (Hardcoded)
        ====================================================== */
        if (
            $request->login === 'admin@gmail.com' &&
            $request->password === 'Applesmart@12345'
        ) {
            Session::put('admin_id', 1);
            Session::put('user_name', 'Admin');
            Session::put('user_role', 'admin');

            return response()->json([
                'status'   => true,
                'message'  => 'Admin login successful',
                'redirect' => route('admindashboard')
            ]);
        }

        /* ======================================================
        CUSTOMER LOGIN
        ====================================================== */
        if ($request->role === 'customer') {

            $user = User::where('mobile', $request->login)
                        ->orWhere('email', $request->login)
                        ->first();

            if (!$user || !Hash::check($request->password, $user->password)) {
                return response()->json([
                    'status'  => false,
                    'message' => 'Invalid customer login details'
                ]);
            }

            Session::put('customer_id', $user->id);
            Session::put('user_name', $user->name);
            Session::put('user_role', 'customer');
            app(HomeController::class)->savePostFromSession();

            return response()->json([
                'status'   => true,
                'message'  => 'Customer login successful',
                'redirect' => route('dashboard')
            ]);
        }

        /* ======================================================
        VENDOR LOGIN
        ====================================================== */
        if ($request->role === 'vendor') {

            $vendor = DB::table('vendor_reg')
                        ->where('mobile', $request->login)
                        ->orWhere('email', $request->login)
                        ->first();

            if (!$vendor || !Hash::check($request->password, $vendor->password)) {
                return response()->json([
                    'status'  => false,
                    'message' => 'Invalid vendor login details'
                ]);
            }

            Session::put('vendor_id', $vendor->id);
            Session::put('user_name', $vendor->name);
            Session::put('user_role', 'vendor');

            return response()->json([
                'status'   => true,
                'message'  => 'Vendor login successful',
                'redirect' => route('vendordashboard')
            ]);
        }

        /* ======================================================
        SUPPLIER LOGIN
        ====================================================== */
        if ($request->role === 'supplier') {

            $supplier = DB::table('supplier_reg')
                        ->where('mobile', $request->login)
                        ->orWhere('email', $request->login)
                        ->first();

            if (!$supplier || !Hash::check($request->password, $supplier->password)) {
                return response()->json([
                    'status'  => false,
                    'message' => 'Invalid supplier login details'
                ]);
            }

            Session::put('supplier_id', $supplier->id);
            Session::put('supplier_name', $supplier->contact_person);
            Session::put('supplier_role', 'supplier');

            return response()->json([
                'status'   => true,
                'message'  => 'Supplier login successful',
                'redirect' => route('supplierdashboard')
            ]);
        }

        return response()->json([
            'status'  => false,
            'message' => 'Invalid role selected'
        ]);
    }

    // ============================= customer DASHBOARD =============================
    public function dashboard()
    {
        if (!Session::has('customer_id')) {
            return redirect('/'); 
        }
        $customer_id = Session::get('customer_id');
        
        $cust_data = DB::table('users')->where('id',$customer_id)->first();
       
        $post_data = DB::table('posts as p')
                    ->leftJoin('state as s', 's.id', '=', 'p.state')
                    ->leftJoin('region as r', 'r.id', '=', 'p.region')
                    ->leftJoin('city as c', 'c.id', '=', 'p.city')
                    ->where('p.user_id',$customer_id)
                    ->select('p.*','s.name as statename',
                            'r.name as regionname',
                            'c.name as cityname')
                    ->get();

        $postIds = DB::table('posts')
                    ->where('user_id', $customer_id)
                    ->pluck('id');
   
        $count_post_data = count($post_data);
        $totalsuppliers = DB::table('supplier_reg')->get();
        $count_suppliers = count($totalsuppliers);

        $vendor_data = DB::table('vendor_reg as v')
                    ->leftJoin('state as s', 's.id', '=', 'v.state')
                    ->leftJoin('region as r', 'r.id', '=', 'v.region')
                    ->leftJoin('city as c', 'c.id', '=', 'v.city')
                    ->select('v.*','s.name as statename',
                            'r.name as regionname',
                            'c.name as cityname')
                    ->orderBy('v.created_at', 'desc') 
                    ->get();
                    


        $count_vendor_data = count($vendor_data);
        
        $customer_interests_data = DB::table('customer_interests')->where('customer_id',$customer_id)->get();

        $count_customer_interests_data = count($customer_interests_data);

        $supp_count =  DB::table('supplier_reg')->get();
        $count_supplier_reg =count($supp_count);
        //vendor intrested to customer
        // $customer_interests= DB::table('vendor_interests')->where('customer_id',$customer_id)->get();
        $customer_interests=DB::table('vendor_interests as vi')
                ->join('vendor_reg as v', 'v.id', '=', 'vi.vendor_id')
                ->whereIn('vi.customer_id', $postIds)
                ->select('v.*','vi.*')
                ->get();
        // dd( $customer_interests);
        $count_customer_interests =count($customer_interests);


        $notifications = DB::table('vendor_interests as vi')
                ->whereIn('vi.customer_id', $postIds)
                ->get();
        $notificationCount = $notifications->count();
      
        return view('web.customerdashboard',compact('post_data','notifications','count_customer_interests','count_supplier_reg','notificationCount','count_post_data','count_vendor_data','vendor_data','cust_data','count_suppliers','count_customer_interests_data')); 
    }

   
    public function customerNotificationsPage()
    {
        $customer_id = Session::get('customer_id');
          
        $cust_data = DB::table('users')->where('id',$customer_id)->first();
        // $post_id = DB::table('posts')->where('user_id',$customer_id )->get();
           
        $postIds = DB::table('posts')
                    ->where('user_id', $customer_id)
                    ->pluck('id');
        // dd($postIds);
        $notifications = DB::table('vendor_interests as vi')
                ->join('vendor_reg as v', 'v.id', '=', 'vi.vendor_id')
                ->whereIn('vi.customer_id', $postIds)
                ->select('v.*','vi.*')
                ->get();
                //  dd($notifications);
        $notificationCount = $notifications->count();

        return view('web.customernotifications', compact('notifications','cust_data','notificationCount'));
    }

    public function vendorNotificationsPage()
    {
        $vendor_id   = Session::get('vendor_id');
        $vendor = DB::table('vendor_reg')
                    ->where('id', $vendor_id)
                    ->first();
        $vendIds = DB::table('vendor_reg')
                    ->where('id', $vendor_id)
                    ->pluck('id');
        //    dd( $vendIds );
        $notifications = DB::table('customer_interests as ci')
                ->join('users as u', 'u.id', '=', 'ci.customer_id')
                ->whereIn('ci.vendor_id', $vendIds)
                // ->select('v.*','vi.*')
                 ->select('ci.*','u.*')
                ->get();
        //    dd( $notifications );     
        $notificationCount = $notifications->count();

        return view('web.vendornotifications', compact('notifications','notificationCount','vendor','vendor_id'));
    }



    public function handleNotificationAction(Request $request)
    {
        $customer_id = Session::get('customer_id');
        $cust_data = DB::table('users')->where('id',$customer_id)->first();
        $request->validate([
            'notification_id' => 'required',
            'action' => 'required|in:accepted,rejected'
        ]);

        DB::table('vendor_interests')
            ->where('id', $request->notification_id)
            ->update([
                'action_status' => $request->action,
                'is_read' => 1,
                'updated_at' => now()
            ]);

        return response()->json(['success' => true]);
    }


    // ============================= Vender DASHBOARD =============================


    public function vendordashboard()
    {
        if (!Session::has('vendor_id')) {
            return redirect('/'); 
        }
        $vendor_id = Session::get('vendor_id');

        
        //   dd($vendor_id);
        $vendor = DB::table('vendor_reg')
                    ->where('id', $vendor_id)
                    ->first();
                    //   dd($vendor);
        $credits=$vendor->lead_balance;       
        $profilePercent = ProfileCompletionHelper::vendor($vendor);
        // dd($profilePercent);
        $vendIds = DB::table('vendor_reg')
                    ->where('id', $vendor_id)
                    ->pluck('id');
        //    dd( $vendIds );
        $notifications = DB::table('customer_interests as ci')
                ->join('users as u', 'u.id', '=', 'ci.customer_id')
                ->whereIn('ci.vendor_id', $vendIds)
                // ->select('v.*','vi.*')
                 ->select('ci.*','u.*')
                ->get();
        //    dd( $notifications );     
        $notificationCount = $notifications->count();
            //  dd($vendor_details);        
        $ActiveLeads  = DB::table('posts')->count();   

        $leadhistory =  DB::table('vendor_interests as vi')
                    ->leftJoin('users as u', 'u.id', '=', 'vi.customer_id')
                    ->where('vi.vendor_id', $vendor_id)->get();
                    // dd($leadhistory );
        $countleadhistory = count($leadhistory);
        $projects  = DB::table('posts as p')
                    ->leftJoin('state as s', 's.id', '=', 'p.state')
                    ->leftJoin('region as r', 'r.id', '=', 'p.region')
                    ->leftJoin('city as c', 'c.id', '=', 'p.city')
                   
                    ->select('p.*','s.name as statename',
                            'r.name as regionname',
                            'c.name as cityname')
                    ->orderBy('p.created_at', 'desc') 
                    ->get();       
        // dd(  );

        return view('web.vendordashboard',compact('ActiveLeads','credits','countleadhistory','profilePercent','projects','vendor','vendor_id','notifications','notificationCount')); 
    }

 
    public function supplierDashboard()
    {
        $supplier_id = Session::get('supplier_id');

        $supplierName = DB::table('supplier_reg')
                        ->where('id', $supplier_id)
                        ->value('contact_person'); 

        /* ===============================
        PRODUCTS STATS
        =============================== */
        $productCount = DB::table('supplier_products_data')
            ->where('supp_id', $supplier_id)
            ->count();
        $supplier_enquiries = DB::table('supplier_enquiries')
            ->where('supplier_id', $supplier_id)
            ->count();
        $avgPrice = DB::table('supplier_products_data')
            ->where('supp_id', $supplier_id)
            ->avg('price');

        $latestProduct = DB::table('supplier_products_data')
            ->where('supp_id', $supplier_id)
            ->latest()
            ->value('price');

      
        $supp_enq_data = DB::table('supplier_enquiries as se')
                            ->leftJoin('users as u', function ($join) {
                                $join->on(DB::raw("SUBSTRING(se.user_id, 3)"), '=', 'u.id')
                                    ->where('se.user_id', 'like', 'c_%');
                            })
                            ->leftJoin('vendor_reg as v', function ($join) {
                                $join->on(DB::raw("SUBSTRING(se.user_id, 3)"), '=', 'v.id')
                                    ->where('se.user_id', 'like', 'v_%');
                            })
                            ->where('se.supplier_id', $supplier_id)
                            ->select(
                                'se.*','v.*',
                                DB::raw("COALESCE(u.name, v.name) as name"),
                                DB::raw("CASE 
                                    WHEN se.user_id LIKE 'c_%' THEN 'customer'
                                    ELSE 'vendor_reg'
                                END as user_type")
                            )
                            ->get();

        $notifications = DB::table('supplier_enquiries as se')
                        ->where('se.supplier_id', $supplier_id)
                        ->get();
                        // dd($notifications);
        $notificationCount = $notifications->count();
        // dd($supp_enq_data);
        /* ===============================
        PRODUCTS ADDED – LAST 7 DAYS
        =============================== */
        $productsByDay = DB::table('supplier_products_data')
            ->selectRaw('DATE(created_at) as date, COUNT(*) as total')
            ->where('supp_id', $supplier_id)
            ->whereDate('created_at', '>=', now()->subDays(6))
            ->groupBy('date')
            ->orderBy('date')
            ->get();
 
        $labels = [];
        $values = [];

        foreach ($productsByDay as $row) {
            $labels[] = date('D', strtotime($row->date));
            $values[] = $row->total;
        }

        /* ===============================
        CATEGORY DISTRIBUTION
        =============================== */
        $categoryData = DB::table('supplier_products_data as sp')
            ->leftJoin('material_categories as mc', 'mc.id', '=', 'sp.material_category_id')
            ->where('sp.supp_id', $supplier_id)
            ->select('mc.name', DB::raw('COUNT(sp.id) as total'))
            ->groupBy('mc.name')
            ->get();
          
        $categoryLabels = $categoryData->pluck('name');
        $categoryCounts = $categoryData->pluck('total');
        return view('web.supplierdashboard', compact(
            'supplierName','supplier_enquiries',
            'productCount',
            'avgPrice','supp_enq_data',
            'latestProduct','notificationCount','notifications',
            'labels',
            'values',
            'categoryLabels',
            'categoryCounts'
        ));
    }


    public function admindashboard(){
        $post_data = DB::table('posts')->get();
        //  dd( $post_data);
        $count_post_data = count($post_data);
        $vendor_data = DB::table('vendor_reg')->get();
        $count_vendor_data = count($vendor_data);

        $supplier_reg =DB::table('supplier_reg')->get();
        $count_supplier_reg = count($supplier_reg);
        return view('web.admindashboard',compact('count_post_data','count_vendor_data','count_supplier_reg'));
    }
  
    // ============================= LOGOUT =============================
    public function logout()
    {
        Session::flush();
        return redirect('/');
    }


    

public function sendOtp(Request $request)
{
    $request->validate([
        'mobile' => 'required',
        'role'   => 'required|in:customer,vendor,supplier'
    ]);

    // Clean number (remove spaces, dashes, etc.)
    $mobile = preg_replace('/[^0-9]/', '', $request->mobile);

    // If starts with 91 and length 12 → remove 91
    if (strlen($mobile) === 12 && substr($mobile, 0, 2) === '91') {
        $mobile = substr($mobile, 2);
    }

    // Must be 10 digit Indian number
    if (strlen($mobile) !== 10) {
        return response()->json([
            'status' => false,
            'message' => 'Invalid mobile number format'
        ]);
    }

    $fullMobile = '+91' . $mobile;

    $otp = rand(100000, 999999);

    Cache::put('otp_' . $mobile, [
        'otp'  => $otp,
        'role' => $request->role
    ], now()->addMinutes(5));

    $sid   = config('services.twilio.sid');
    $token = config('services.twilio.token');
    $from  = config('services.twilio.from');
    // dd(config('services.twilio'));

    // Check config exists
    if (!$sid || !$token || !$from) {
        return response()->json([
            'status' => false,
            'message' => 'Twilio configuration missing'
        ]);
    }

    try {

        $client = new Client($sid, $token);

        $client->messages->create(
            $fullMobile,
            [
                'from' => $from,
                'body' => "Your ConstructKaro OTP is {$otp}. Valid for 5 minutes."
            ]
        );

        return response()->json([
            'status' => true,
            'message' => 'OTP sent successfully'
        ]);

    } catch (\Exception $e) {

        return response()->json([
            'status' => false,
            'message' => 'Twilio Error: ' . $e->getMessage()
        ]);
    }
}

public function verifyOtp(Request $request)
{
    $login = preg_replace('/[^0-9]/', '', $request->login);
    $otp   = $request->otp;
    $role  = $request->role;

    // Remove +91 if present
    if (strlen($login) === 12 && substr($login, 0, 2) === '91') {
        $login = substr($login, 2);
    }

    // 🔐 Get OTP from cache
    $cached = Cache::get('otp_' . $login);

    if (!$cached) {
        return response()->json([
            'status' => false,
            'message' => 'OTP expired or not found'
        ]);
    }

    if ($cached['otp'] != $otp) {
        return response()->json([
            'status' => false,
            'message' => 'Invalid OTP'
        ]);
    }

    if ($cached['role'] !== $role) {
        return response()->json([
            'status' => false,
            'message' => 'Role mismatch'
        ]);
    }

    // ✅ OTP verified — remove from cache
    Cache::forget('otp_' . $login);

    return response()->json([
        'status' => true,
        'message' => 'OTP verified successfully'
    ]);
}


public function resetPassword(Request $request)
{
    $request->validate([
        'login'    => 'required',
        'role'     => 'required|in:customer,vendor,supplier',
        'password' => 'required|min:6'
    ]);

    $login = preg_replace('/[^0-9]/', '', $request->login);
    $role  = $request->role;
    $password = Hash::make($request->password);

    // 🔐 Map role to correct table
    $tables = [
        'customer' => 'users',
        'vendor'   => 'vendor_reg',
        'supplier' => 'supplier_reg'
    ];

    if (!isset($tables[$role])) {
        return response()->json([
            'status' => false,
            'message' => 'Invalid role'
        ]);
    }

    $table = $tables[$role];


    // ✅ Update password
    DB::table($table)
        ->where(function ($q) use ($login) {
            $q->where('mobile', $login)
              ->orWhere('email', $login);
        })
        ->update([
            'password' => $password
        ]);

    // 🔥 Clear verification flag
    // Cache::forget($verifiedKey);

    return response()->json([
        'status' => true,
        'message' => 'Password changed successfully'
    ]);
}
}
