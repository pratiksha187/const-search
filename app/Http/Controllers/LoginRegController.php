<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class LoginRegController extends Controller
{

    public function login_register(){
        // $materialCategories = DB::table('material_categories')->get();

        return view('web.login_register');
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
        // dd('test');
        if (!Session::has('customer_id')) {
            return redirect('/'); 
        }
        $customer_id = Session::get('customer_id');
        //  dd($customer_id);
        $cust_data = DB::table('users')->where('id',$customer_id)->first();
        //  dd( $cust_data);
        $post_data = DB::table('posts')->where('user_id',$customer_id)->get();

        $postIds = DB::table('posts')
                    ->where('user_id', $customer_id)
                    ->pluck('id');
        // dd( $post_data);
        $count_post_data = count($post_data);
        //  dd( $post_data);
        $totalsuppliers = DB::table('supplier_reg')->get();
        $count_suppliers = count($totalsuppliers);

        $vendor_data = DB::table('vendor_reg')->get();
        //  dd( $vendor_data);
        $count_vendor_data = count($vendor_data);
        
        $customer_interests_data = DB::table('customer_interests')->where('customer_id',$customer_id)->get();
        $count_customer_interests_data = count($customer_interests_data);

        $notifications = DB::table('vendor_interests as vi')
                // ->join('vendor_reg as v', 'v.id', '=', 'vi.vendor_id')
                ->whereIn('vi.customer_id', $postIds)
            
                ->get();
        $notificationCount = $notifications->count();
      
        //  dd($post_data);
        return view('web.customerdashboard',compact('post_data','notifications','notificationCount','count_post_data','count_vendor_data','vendor_data','cust_data','count_suppliers','count_customer_interests_data')); 
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
        $ActiveLeads  = DB::connection('mysql')->table('posts')->count();   
        $projects  = DB::connection('mysql')->table('posts')->get();       
        // dd( $ActiveLeads_data );

        return view('web.vendordashboard',compact('ActiveLeads','projects','vendor','vendor_id','notifications','notificationCount')); 
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
            'avgPrice',
            'latestProduct',
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
}
