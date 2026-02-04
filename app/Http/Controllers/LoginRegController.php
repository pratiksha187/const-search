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

class LoginRegController extends Controller
{

    public function login_register(){
        // $materialCategories = DB::table('material_categories')->get();

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
                    'message' => 'customer already registered with this mobile or email'
                ]);
            }
        }


        /* ================= ROLE BASE INSERT + SESSION ================= */

        if ($request->role === 'vendor') {

            $vendorId = DB::table('vendor_reg')->insertGetId([
                // 'user_id'       => $user->id,
                'name'          => $request->name,
                'mobile'        => $request->mobile,
                'email'         => $request->email,
                'business_name' => $request->business_name ?? null,
                'gst_number'    => $request->gst_number ?? null,
                'status'        => 'pending',
                'password'      => Hash::make($request->password),
                'created_at'    => now(),
                'updated_at'    => now()
            ]);

            Session::put('vendor_id', $vendorId);
        }

        elseif ($request->role === 'supplier') {
            // dd($request);
            $supplierId = DB::table('supplier_reg')->insertGetId([
                'shop_name'         => $request->shop_name,
                // 'material_category' => $request->material_category,
                'contact_person' => $request->name,
                'mobile'         => $request->mobile,
                'email'          => $request->email,
                'status'         => 'pending',
                'password'       => Hash::make($request->password),
                'created_at'     => now(),
                'updated_at'     => now()
            ]);

            Session::put('supplier_id', $supplierId);
        }

        elseif($request->role === 'customer') {
           
             $customerId = DB::table('users')->insertGetId([
                // 'user_id'         => $user->id,
                'name' => $request->name,
                'mobile'         => $request->mobile,
                'email'          => $request->email,
                'role'         => 'pending',
                'password'       => Hash::make($request->password),
                'created_at'     => now(),
                'updated_at'     => now()
            ]);

            //  dd($customerId);
            // customer
           Session::put('customer_id', $customerId);
            app(HomeController::class)->savePostFromSession();
        }

        $redirectUrl = match ($request->role) {
            'vendor'   => route('vendordashboard'),
            'supplier' => route('suppliers.profile'),
            'customer'    => route('dashboard'),
        };

        return response()->json([
            'status'   => true,
            'message'  => ucfirst($request->role).' registration successful',
            'redirect' => $redirectUrl
        ]);
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

        $customer_interests= DB::table('customer_interests')->where('customer_id',$customer_id)->get();
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
            // dd($cust_data);
        $postIds = DB::table('posts')
                    ->where('user_id', $customer_id)
                    ->pluck('id');
       
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
        $projects  = DB::table('posts as p')
                    ->leftJoin('state as s', 's.id', '=', 'p.state')
                    ->leftJoin('region as r', 'r.id', '=', 'p.region')
                    ->leftJoin('city as c', 'c.id', '=', 'p.city')
                   
                    ->select('p.*','s.name as statename',
                            'r.name as regionname',
                            'c.name as cityname')
                    ->orderBy('p.created_at', 'desc') 
                    ->get();       
        // dd( $projects );

        return view('web.vendordashboard',compact('ActiveLeads','profilePercent','projects','vendor','vendor_id','notifications','notificationCount')); 
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

        // $supp_enq_data= DB::table('supplier_enquiries as se')
        //                 ->leftJoin('users as u', 'u.id', '=', 'se.user_id')
        //                 ->where('supplier_id', $supplier_id)
        //                 ->get();
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


    
     /* ===========================
       SEND OTP (MOBILE / EMAIL)
    ============================*/
   
public function sendOtp(Request $request)
{
    $request->validate([
        'mobile' => 'required|digits:10'
    ]);

    $otp = rand(100000, 999999);

    Session::put('otp', $otp);
    Session::put('mobile', $request->mobile);

    try {
        $client = new Client(
            config('services.twilio.sid'),
            config('services.twilio.token')
        );

        $client->messages->create(
            '+91'.$request->mobile,
            [
                'from' => config('services.twilio.from'),
                'body' => "Your ConstructKaro OTP is $otp"
            ]
        );

        return response()->json([
            'status' => true,
            'message' => 'OTP sent successfully'
        ]);

    } catch (\Exception $e) {
        return response()->json([
            'status' => false,
            'message' => $e->getMessage()
        ]);
    }
}

    /* ===========================
       VERIFY OTP
    ============================*/
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required|digits:6'
        ]);

        if ($request->otp == Session::get('fp_otp')) {
            return response()->json(['status' => true]);
        }

        return response()->json([
            'status' => false,
            'message' => 'Invalid OTP'
        ]);
    }

    /* ===========================
       RESET PASSWORD
    ============================*/
    public function resetPassword(Request $request)
    {
        $request->validate([
            'password' => 'required|min:6'
        ]);

        $login = Session::get('fp_login');
        $role  = Session::get('fp_role');

        $user = User::where('role', $role)
            ->where(function ($q) use ($login) {
                $q->where('email', $login)
                  ->orWhere('mobile', $login);
            })
            ->first();

        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'User not found'
            ]);
        }

        $user->password = Hash::make($request->password);
        $user->save();

        Session::forget(['fp_otp','fp_login','fp_role']);

        return response()->json([
            'status' => true,
            'message' => 'Password updated successfully'
        ]);
    }


}
