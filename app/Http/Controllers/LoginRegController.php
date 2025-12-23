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
        return view('web.login_register');
    }

     // ============================= REGISTER =============================
  
    // public function register(Request $request)
    // {
    //     $request->validate([
    //         'role'     => ['required'],
    //         'name'     => ['required'],
    //         'mobile'   => ['required'],
    //         'email'    => ['required'],
    //         'password' => ['required', 'min:4']
    //     ]);
    //     // dd($request);
    //     /* ---------------- VENDOR DUPLICATE CHECK (ONLY vendor_reg) ---------------- */
    //     if ($request->role === 'vendor') {

    //         $vendorExists = DB::table('vendor_reg')
    //             ->where('mobile', $request->mobile)
    //             ->orWhere('email', $request->email)
    //             ->exists();

    //         if ($vendorExists) {
    //             return response()->json([
    //                 'status'  => false,
    //                 'message' => 'Vendor already registered with this mobile or email'
    //             ]);
    //         }
    //     }

    //     /* ---------------- USER CREATE (NO DUPLICATE CHECK HERE) ---------------- */
    //     $user = User::create([
    //         'role'     => $request->role,
    //         'name'     => $request->name,
    //         'mobile'   => $request->mobile,
    //         'email'    => $request->email,
    //         'password' => Hash::make($request->password)
    //     ]);

    //     /* ---------------- VENDOR EXTRA LOGIC ---------------- */
    //     if ($request->role === 'vendor') {

    //         DB::table('vendor_reg')->insert([
    //             'user_id'       => $user->id,
    //             'name'          => $request->name,
    //             'mobile'        => $request->mobile,
    //             'email'         => $request->email,
    //             'business_name' => $request->business_name ?? null,
    //             'gst_number'    => $request->gst_number ?? null,
    //             'status'        => 'pending',
    //             'password' => Hash::make($request->password),
    //             'created_at'    => now(),
    //             'updated_at'    => now()
    //         ]);
    //     }

    //     /* ---------------- SESSION ---------------- */
    //     Session::put('user_id', $user->id);
    //     Session::put('user_name', $user->name);
    //     Session::put('user_role', $user->role);

    //     return response()->json([
    //         'status'   => true,
    //         'message'  => 'Registration successful',
    //         'redirect' => route('dashboard')
    //     ]);
    // }

    
   
    public function register(Request $request)
    {
        /* ================= VALIDATION ================= */

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

        /* ================= USER CREATE ================= */

        $user = User::create([
            'role'     => $request->role,
            'name'     => $request->name,
            'mobile'   => $request->mobile,
            'email'    => $request->email,
            'password' => Hash::make($request->password)
        ]);

        /* ================= ROLE BASE INSERT + SESSION ================= */

        if ($request->role === 'vendor') {

            $vendorId = DB::table('vendor_reg')->insertGetId([
                'user_id'       => $user->id,
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

            $supplierId = DB::table('supplier_reg')->insertGetId([
                'user_id'         => $user->id,
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

        else {
            // customer
            Session::put('customer_id', $user->id);
        }

        /* ================= COMMON SESSION ================= */

        Session::put('user_id', $user->id);
        Session::put('user_name', $user->name);
        Session::put('user_role', $user->role);

        /* ================= ROLE BASE REDIRECT ================= */

        $redirectUrl = match ($request->role) {
            'vendor'   => route('vendordashboard'),
            'supplier' => route('supplierdashboard'),
            default    => route('dashboard'),
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
        // dd($request);
        $request->validate([
            'login'    => 'required',   // mobile or email
            'password' => 'required',
            'role'     => 'required'
        ]);

        /* ======================================================
        CUSTOMER LOGIN (users table only)
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

            // Session
            Session::put('user_id', $user->id);
            Session::put('user_name', $user->name);
            Session::put('user_role', 'customer');

            return response()->json([
                'status'   => true,
                'message'  => 'Customer login successful',
                'redirect' => route('dashboard')
            ]);
        }

        /* ======================================================
        VENDOR LOGIN (vendor_reg table only)
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

          
            // Session (IMPORTANT)
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
        supplier LOGIN (suplier table only)
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

          
            // Session (IMPORTANT)
            Session::put('supplier_id', $supplier->id);
            Session::put('user_name', $supplier->contact_person);
            Session::put('user_role', 'supplier');

            return response()->json([
                'status'   => true,
                'message'  => 'supplier login successful',
                'redirect' => route('supplierdashboard')
            ]);
        }

        /* ======================================================
        INVALID ROLE
        ====================================================== */
        return response()->json([
            'status'  => false,
            'message' => 'Invalid role selected'
        ]);
    }


    // ============================= customer DASHBOARD =============================
    public function dashboard()
    {
        if (!Session::has('user_id')) {
            return redirect('/'); 
        }
    $user_id = Session::get('user_id');
 
        return view('web.customerdashboard'); 
    }

    // ============================= Vender DASHBOARD =============================


    public function vendordashboard()
    {
        if (!Session::has('vendor_id')) {
            return redirect('/'); 
        }
        $vendor_id = Session::get('vendor_id');
        //   dd($vendor_id);
        $vendor_details = DB::table('vendor_reg')
                    ->where('id', $vendor_id)
                    ->first();
        $ActiveLeads  = DB::connection('mysql')->table('posts')->count();   
        $projects  = DB::connection('mysql')->table('posts')->get();       
        // dd( $ActiveLeads_data );

        return view('web.vendordashboard',compact('ActiveLeads','projects')); 
    }

    // ============================= supplierdashboard =============================
    public function supplierdashboard()
    {
        
        if (!Session::has('supplier_id')) {
            return redirect('/'); 
        }

        $supplier_id = Session::get('supplier_id');
        // dd($supplier_id);
        return view('web.supplierdashboard'); 
    }
    
    
    // ============================= LOGOUT =============================
    public function logout()
    {
        Session::flush();
        return redirect('/');
    }
}
