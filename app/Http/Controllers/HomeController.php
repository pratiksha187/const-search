<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Helpers\ProfileCompletionHelper;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{
    public function homepage(){
        
        $vendors = DB::table('vendor_reg')->count();
        $cities =DB::table('city')->count();
        $posts= DB::table('posts')->count();
        //  dd( $vendors);
        return view('welcome',compact('vendors','posts','cities'));
    }

    public function aboutus(){
        return view('web.about');
    }

    public function index()
    {
        $customer_id = Session::get('customer_id');
        $cust_data = DB::table('users')->where('id',$customer_id)->first();
        $work_types = DB::table('work_types')->get();
        $work_subtypes = DB::table('work_subtypes')->get();
        $states = DB::table('state')->orderBy('name')->get();
        $budget_range = DB::table('budget_range')->get();
        $posts = DB::table('posts')
            ->leftJoin('budget_range', 'posts.budget_id', '=', 'budget_range.id')
            ->leftJoin('work_types', 'posts.work_type_id', '=', 'work_types.id')
            ->leftJoin('work_subtypes', 'posts.work_subtype_id', '=', 'work_subtypes.id')
            ->leftJoin('region', 'region.id', '=', 'posts.region')
            ->leftJoin('city', 'city.id', '=', 'posts.city')
            ->leftJoin('state', 'state.id', '=', 'posts.state')
            ->select(
                    'posts.*',

                    // ✅ IMPORTANT: SEND IDS TO FRONTEND
                    'posts.state as state_id',
                    'posts.region as region_id',
                    'posts.city as city_id',
                    

                    // Names (for table display)
                    'state.name as statename',
                    'region.name as regionname',
                    'city.name as cityname',

                    'work_types.work_type as work_type_name',
                    'work_subtypes.work_subtype as work_subtype_name',

                    // ✅ IMPORTANT FOR EDIT BUDGET
                    'posts.budget_id as budget_id',
                    'budget_range.budget_range as budget_range'
                )
                ->where('posts.user_id', $customer_id)

                ->orderBy('posts.id', 'DESC')
                ->paginate(10);

       
        $postIds = DB::table('posts')
                    ->where('user_id', $customer_id)
                    ->pluck('id');
        $notifications = DB::table('vendor_interests as vi')
                // ->join('vendor_reg as v', 'v.id', '=', 'vi.vendor_id')
                ->whereIn('vi.customer_id', $postIds)
            
                ->get();
        $notificationCount = $notifications->count();
        return view('web.my-posts', compact('posts','work_types','cust_data','notifications','budget_range','notificationCount','states'));
    }

    public function post(){
        $customer_id = Session::get('customer_id');
        // dd( $customer_id);
        $postIds = DB::table('posts')
                    ->where('user_id', $customer_id)
                    ->pluck('id');
        $notifications = DB::table('vendor_interests as vi')
                // ->join('vendor_reg as v', 'v.id', '=', 'vi.vendor_id')
                ->whereIn('vi.customer_id', $postIds)
            
                ->get();
        $notificationCount = $notifications->count();
        $cust_data = DB::table('users')->where('id',$customer_id)->first();
        $work_types = DB::table('work_types')->get();
        $states = DB::table('state')->orderBy('name')->get();

        $work_subtypes = DB::table('work_subtypes')->get();
        $budget_range = DB::table('budget_range')->get();

        $unit = DB::table('cust_unit')->get();
        return view('web.post',compact('work_subtypes','customer_id','budget_range','unit','work_types','states','cust_data','notifications','notificationCount'));
    }

    public function getProjectTypes($workTypeId)
    {
         $subtypes = DB::table('work_subtypes')
                    ->where('work_type_id', $workTypeId)
                    ->get();
        return response()->json($subtypes);
    }

    public function getRegions($state_id)
    {
        $regions = DB::table('regions')
            ->where('states_id', $state_id)
            ->get();

        return response()->json($regions);
    }

    public function getCities($region_id)
    {
        $cities = DB::table('cities')
            ->where('regions_id', $region_id)
            ->get();

        return response()->json($cities);
    }
  
  
    public function cutomerprofile()
    {
        $customer_id = Session::get('customer_id');
        $postIds = DB::table('posts')
                    ->where('user_id', $customer_id)
                    ->pluck('id');
        $notifications = DB::table('vendor_interests as vi')
                // ->join('vendor_reg as v', 'v.id', '=', 'vi.vendor_id')
                ->whereIn('vi.customer_id', $postIds)
            
                ->get();
        $notificationCount = $notifications->count();
      
        //   $cust_data = DB::table('users')->where('id',$customer_id)->first();
        $cust_data = DB::table('users')->where('id', $customer_id)->first();

        return view('web.cutomerprofile', compact('cust_data','notifications','notificationCount'));
    }
    
   
    public function cutomerupdate(Request $request)
    {
        $customer_id = Session::get('customer_id');

        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email',
            'mobile'   => 'nullable|string|max:15',
            'password' => 'nullable|confirmed|min:6',
        ]);

        $data = [
            'name'   => $request->name,
            'email'  => $request->email,
            'mobile' => $request->mobile,
        ];

        if ($request->password) {
            $data['password'] = Hash::make($request->password);
        }

        DB::table('users')->where('id', $customer_id)->update($data);

        return back()->with('success', 'Profile updated successfully');
    }

   

    public function search_vendor(Request $request)
    {
       
        $customer_id = Session::get('customer_id');
        $postIds = DB::table('posts')
                    ->where('user_id', $customer_id)
                    ->pluck('id');
        $notifications = DB::table('vendor_interests as vi')
                // ->join('vendor_reg as v', 'v.id', '=', 'vi.vendor_id')
                ->whereIn('vi.customer_id', $postIds)
            
                ->get();
        $notificationCount = $notifications->count();
        $cust_data = DB::table('users')->where('id',$customer_id)->first();
        
        $work_types = DB::table('work_types')->orderBy('work_type')->get();
        $states     = DB::table('state')->orderBy('name')->get();

        $allSubtypes = DB::table('work_subtypes')
            ->pluck('work_subtype', 'id');

       
        $vendor_reg = DB::table('vendor_reg as v')
                    ->leftJoin('work_types as wt', 'wt.id', '=', 'v.work_type_id')
                    ->leftJoin('team_size as ts', 'ts.id', '=', 'v.team_size')
                    ->leftJoin('experience_years as ey', 'ey.id', '=', 'v.experience_years')


                    // ✅ FIXED JOIN
                    ->leftJoin('vendor_ratings as vr', 'vr.vendor_id', '=', 'v.id')

                    ->leftJoin('state as s', 's.id', '=', 'v.state')
                    ->leftJoin('region as r', 'r.id', '=', 'v.region')
                    ->leftJoin('city as c', 'c.id', '=', 'v.city')

                    ->select(
                        'v.*',

                        // ✅ AGGREGATES
                        DB::raw('ROUND(AVG(vr.rating), 1) as avg_rating'),
                        DB::raw('COUNT(vr.id) as total_reviews'),

                        // work
                        'wt.work_type',
                        'ts.team_size as team_size_data',

                        'ey.experiance as experiance',

                        // location
                        's.name as statename',
                        'r.name as regionname',
                        'c.name as cityname'
                    )

                    // ✅ REQUIRED GROUP BY
                    ->groupBy(
                        'v.id',
                        'wt.work_type',
                        'ts.team_size',
                        's.name',
                        'r.name',
                        'c.name'
                    )

                    ->orderBy('v.id', 'desc')
                    ->get();

        // dd($vendor_reg);
        $vendorsWithProfile = $vendor_reg->map(function ($vendor) {
            $vendor->profile_percent = ProfileCompletionHelper::vendor($vendor);
            return $vendor;
        });
        // dd($vendorsWithProfile);
        $vendorIds = DB::table('vendor_reg')
                    ->pluck('id');
        $vendors = DB::table('vendor_reg as v')->whereIn('id', $vendorIds)->get();
                    // dd($vendors);
        $vendor_reg->transform(function ($vendor) use ($allSubtypes) {

            // decode JSON ["16","17","19"]
            $ids = json_decode($vendor->work_subtype_id, true);

            if (!is_array($ids)) {
                $ids = [];
            }

            // map id -> name
            $vendor->work_subtype_data = collect($ids)
                ->map(fn ($id) => $allSubtypes[$id] ?? null)
                ->filter()
                ->values()
                ->implode(', ');

            return $vendor;
        });
       
        return view('web.search_vendor', [
            'cust_data' =>$cust_data,
            'notifications'=>$notifications,
            'notificationCount'=>$notificationCount,
            'work_types'  => $work_types,
            'states'      => $states,
            'vendor_reg'  => $vendor_reg,
            'customer_id' => $customer_id
        ]);
    }
    
    public function search_customer(Request $request)
    {
        $vendor_id = Session::get('vendor_id');
        // dd($vendor_id);
        $vendor = DB::table('vendor_reg')
                    ->where('id', $vendor_id)
                    ->first();
            // dd($vendor);
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
        $states = DB::table('state')->orderBy('name')->get();
      
        $work_types = DB::table('work_types')->get();
        $work_subtypes = DB::table('work_subtypes')
                        ->get()
                        ->groupBy('work_type_id');
        
        $projects = DB::table('posts')
            ->leftJoin('work_types', 'work_types.id', '=', 'posts.work_type_id')

            ->leftJoin('users','users.id', '=','posts.user_id')
            ->leftJoin('budget_range', 'budget_range.id', '=', 'posts.budget_id')
            ->leftJoin('work_subtypes', 'work_subtypes.id', '=', 'posts.work_subtype_id')
            ->leftJoin('region', 'region.id', '=', 'posts.region')
            ->leftJoin('state', 'state.id', '=', 'posts.state')
            ->leftJoin('city', 'city.id', '=', 'posts.city')
            
            ->select(
                'users.name as username',
                'users.mobile as usersmobile',
                'users.email as useremail',
                'work_types.*',
                'work_subtypes.*',
                'posts.*',
                'budget_range.budget_range as budget_range_name',
                'region.name as regionname','state.name as statename','city.name as cityname'      

               
            )
            ->where('post_verify',1)
            ->orderBy('posts.id', 'desc')
            ->get();


            $complited_project= DB::table('posts')->where('get_vendor',1)->get();
            $remaining_projects= DB::table('posts')->where('get_vendor',0)->get();
            
            //    dd($projects);
        return view('web.search_customer', [
            'notifications'=>$notifications,
            'complited_project'=>$complited_project,
            'remaining_projects'=>$remaining_projects,
            'notificationCount' => $notificationCount,
            'work_types' => $work_types,
            'states' => $states,
            'projects' => $projects, 
            'vendor_id' => $vendor_id,
            'vendor' =>$vendor,
            'filters' => []        
        ]);
    }


    public function vendorinterestcheck(Request $request)
    {
       
        $cust_id   = $request->cust_id;
        // dd($cust_id );
        $vendor_id = Session::get('vendor_id');

        if (!$vendor_id) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $already = DB::table('vendor_interests')
            ->where('customer_id', $cust_id)
            ->where('vendor_id', $vendor_id)
            ->exists();
            //  dd($already);
        if ($already) {
            return response()->json([
                'success' => true,
                'already_exists' => true,
                'payment_required' => false,
                'remaining' => null
            ]);
        }

        /* ===============================
        2️⃣ CHECK LEAD BALANCE
        ================================ */
        $leadBalance = DB::table('vendor_reg')
            ->where('id', $vendor_id)
            ->value('lead_balance');

        if ($leadBalance <= 0) {
            return response()->json([
                'success' => false,
                'already_exists' => false,
                'payment_required' => true,
                'remaining' => 0
            ]);
        }

        /* ===============================
        3️⃣ CONSUME 1 LEAD
        ================================ */
        DB::beginTransaction();

        DB::table('vendor_interests')->insert([
            'customer_id' => $cust_id,
            'vendor_id'   => $vendor_id,
            'vendor_name' => $request->vendor_name,
            'created_at'  => now()
        ]);
        

        DB::table('vendor_reg')
            ->where('id', $vendor_id)
            ->decrement('lead_balance', 1);

        DB::commit();

        return response()->json([
            'success' => true,
            'already_exists' => false,
            'payment_required' => false,
            'remaining' => $leadBalance - 1
        ]);
    }



    public function customerinterestcheck(Request $request)
    {
        $customer_id = Session::get('customer_id');

        if (!$customer_id) {
            return response()->json([
                'authorized' => false
            ], 401);
        }

        // Prevent duplicate interest
        $alreadyInterested = DB::table('customer_interests')
            ->where('customer_id', $customer_id)
            ->where('vendor_id', $request->vend_id)
            ->exists();

        if ($alreadyInterested) {
            return response()->json([
                'authorized' => true,
                'message' => 'Already submitted'
            ]);
        }

        DB::table('customer_interests')->insert([
            'customer_id'   => $customer_id,
            'vendor_id'     => $request->vend_id,
            'customer_name' => $request->customer_name,
            'work_type'     => $request->work_type,
            'location'      => $request->location,
            'project_size'  => $request->project_size,
            'timeline'      => $request->timeline,
            'created_at'    => now()
        ]);

        return response()->json([
            'authorized' => true,
            'payment_required' => false
        ]);
    }



    public function projectInterestCheck(Request $request)
    {
        $vendorId  = session('vendor_id');
    
        $projectId = $request->project_id;

        if (!$vendorId || !$projectId) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        // Total interests used
        $used = DB::table('customer_notifications')
            ->where('vendor_id', $vendorId)
            ->count();
        //  dd($used);
        // If limit exceeded → payment required
        if ($used >= 5) {
            return response()->json([
                'payment_required' => true
            ]);
        }

        // Prevent duplicate interest
        $already = DB::table('customer_notifications')
            ->where('vendor_id', $vendorId)
            ->where('customer_id', $projectId)
            ->exists();

        if (!$already) {
            DB::table('customer_notifications')->insert([
                'vendor_id'  => $vendorId,
                'customer_id' => $projectId,
                'created_at' => now()
            ]);
        }

        return response()->json([
            'success' => true,
            'payment_required' => false,
            'remaining' => 5 - ($used + 1)
        ]);
    }

    
 public function store(Request $request)
    {
        $customer_id = Session::get('customer_id');

        /* ================= VALIDATION ================= */
        $request->validate([
            'title'           => 'required|string|max:255',
            'work_type_id'    => 'required|integer',
            'work_subtype_id' => 'required|integer',
            'budget'          => 'required|integer',
            'contact_name'    => 'required|string|max:255',
            'mobile'          => 'required|string|max:20',
            'email'           => 'required|email',
            'description'     => 'required|string',
            'area'            => 'required|string',
        ]);

        /* =====================================================
           🟡 GUEST USER → STORE IN SESSION
        ===================================================== */
        if (!$customer_id) {

            Session::put('pending_post', $request->except(['_token', 'files']));

            $tempFiles = [];
            if ($request->hasFile('files')) {
                foreach ($request->file('files') as $file) {
                    $name = time().'_'.uniqid().'.'.$file->getClientOriginalExtension();
                    $file->move(public_path('uploads/temp_posts'), $name);
                    $tempFiles[] = $name;
                }
            }

            Session::put('pending_post_files', $tempFiles);

            return response()->json([
                'status' => 'login_required',
                'message' => 'Login required'
            ]);
        }

        /* =====================================================
           POST LIMIT CHECK
        ===================================================== */
        $count = DB::table('posts')->where('user_id', $customer_id)->count();
        if ($count >= 3) {
            return response()->json([
                'status' => 'payment_required'
            ]);
        }

        /* =====================================================
           SAVE POST DIRECTLY (LOGGED IN)
        ===================================================== */
        $this->insertPost(
            $customer_id,
            $request->all(),
            $request->file('files')
        );

        return response()->json([
            'status' => 'success',
            'message' => 'Project Posted Successfully',
            'redirect' => route('myposts')
        ]);
    }

    /* =====================================================
       SAVE POST FROM SESSION (AFTER LOGIN / REGISTER)
    ===================================================== */
    public function savePostFromSession()
    {
        if (
            !Session::has('customer_id') ||
            !Session::has('pending_post')
        ) {
            return;
        }

        $customer_id = Session::get('customer_id');
        $data  = Session::get('pending_post');
        $files = Session::get('pending_post_files', []);

        $this->insertPost($customer_id, $data, $files, true);

        Session::forget([
            'pending_post',
            'pending_post_files'
        ]);
    }

    /* =====================================================
       COMMON INSERT METHOD (SINGLE SOURCE OF TRUTH)
    ===================================================== */
    private function insertPost($customer_id, $data, $files, $fromSession = false)
    {
        $uploaded = [];

        if ($files) {
            foreach ($files as $file) {

                if ($fromSession) {
                    // move temp → final
                    rename(
                        public_path("uploads/temp_posts/$file"),
                        public_path("uploads/posts/$file")
                    );
                    $uploaded[] = $file;
                } else {
                    $name = time().'_'.uniqid().'.'.$file->getClientOriginalExtension();
                    $file->move(public_path('uploads/posts'), $name);
                    $uploaded[] = $name;
                }
            }
        }

        DB::table('posts')->insert([
            'user_id'         => $customer_id,
            'title'           => $data['title'],
            'work_type_id'    => $data['work_type_id'],
            'work_subtype_id' => $data['work_subtype_id'],
            'area'            => $data['area'],
            'state'           => $data['state'] ?? null,
            'region'          => $data['region_id'] ?? null,
            'city'            => $data['city_id'] ?? null,
            'budget_id'       => $data['budget'],
            'contact_name'    => $data['contact_name'],
            'mobile'          => $data['mobile'],
            'email'           => $data['email'],
            'description'     => $data['description'],
            'files'           => json_encode($uploaded),
            'created_at'      => now(),
            'updated_at'      => now(),
        ]);
    }
   
    public function leadmarketplace(){
        return view('web.lead_marketplace');
    }


    public function vendorNotifications()
    {
        // $vendor_id = Session::get('user_id');
        $vendor_id = Session::get('vendor_id');
        
        $notifications = DB::table('vendor_notifications')
            ->where('vendor_id', $vendor_id)
            ->orderBy('id', 'DESC')
            ->get();
            // dd( $notifications);
        return view('web.notifications', compact('notifications'));
    }


 
    public function storeleadform(Request $request)
    {

        // Save into Existing DB Table (modify table name as per your DB)
        DB::table('lead_form_inquiries')->insert([
            'name' => $request->name,
            'company_name' => $request->company_name,
            'phone' => $request->phone,
            'email' => $request->email,
            'requirement' => $request->requirement,
            'created_at' => now(),
        ]);

        return back()->with('success', 'Thank you! We will contact you soon.');
    }

    public function vendor_reg_form(){
        return view('web.vendor_reg_form');
    }


    public function updateposts(Request $request, $id)
    {
        $customer_id = Session::get('customer_id');

        $request->validate([
            'title'         => 'required|string|max:255',
            'work_type_id'  => 'required',
            'state_id'      => 'required',
            'region_id'     => 'required',
            'city_id'       => 'required',
            'budget'        => 'nullable|string',
            'description'   => 'nullable|string',
        ]);

        $updated = DB::table('posts')
            ->where('id', $id)
            // ->where('user_id', $customer_id) // enable later
            ->update([
                'title'            => $request->title,
                'work_type_id'     => $request->work_type_id,
                'work_subtype_id'  => $request->work_subtype_id ?? null,

                // ✅ SAVE IDS CORRECTLY
                'state'            => $request->state_id,
                'region'           => $request->region_id,
                'city'             => $request->city_id,

                // ✅ FIXED: store string budget
                'budget_id'     => $request->budget,

                'contact_name'     => $request->contact_name,
                'mobile'           => $request->mobile,
                'email'            => $request->email,
                'description'      => $request->description,
                'updated_at'       => now(),
            ]);

        if (!$updated) {
            return redirect()->back()
                ->with('error', 'Post not found or update failed.');
        }

        return redirect()->back()
            ->with('success', 'Post updated successfully');
    }

    /* =========================
       DELETE POST
    ========================== */
    public function destroy($id)
    {
    $vendor_id = Session::get('user_id');

    $deleted = DB::connection('mysql')
        ->table('posts')
        ->where('id', $id)              // ✅ post id
        ->where('user_id', $vendor_id)  // ✅ owner check
        ->delete();

    if (!$deleted) {
        return redirect()->back()->with('error', 'Post not found or you are not allowed to delete it.');
    }

    return redirect()->back()->with('success', 'Post deleted successfully');
    }

    public function saveErpInterest(Request $request)
    {
        $request->validate([
            'full_name'          => 'required|string|max:150',
            'company_name'       => 'required|string|max:200',
            'role_in_org'        => 'required|string|max:100',
            'organization_type'  => 'required|string',
            'project_size'       => 'required|string',
            'looking_for'        => 'required|array',
            'current_challenge'  => 'required|string',
            'interest_level'     => 'required|string',
            'contact_details'    => 'required|string'
        ]);

        // ✅ HANDLE ROLE "OTHER"
        $role = $request->role_in_org === 'Other'
            ? $request->role_in_org_other
            : $request->role_in_org;

        // ✅ HANDLE ORG TYPE "OTHER"
        $organizationType = $request->organization_type === 'Other'
            ? $request->organization_type_other
            : $request->organization_type;

        DB::table('erp_interest_registrations')->insert([
            'full_name'         => $request->full_name,
            'company_name'      => $request->company_name,
            'role_in_org'       => $role,
            'organization_type' => $organizationType,
            'project_size'      => $request->project_size,
            'looking_for'       => json_encode($request->looking_for),
            'current_challenge' => $request->current_challenge,
            'interest_level'    => $request->interest_level,
            'contact_details'   => $request->contact_details,
            'created_at'        => now(),
            'updated_at'        => now()
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Interest registered successfully'
        ]);
    }


    public function projectslist(){
        $projects = DB::table('posts')
                ->orderBy('created_at', 'desc')
                ->get();
        return view('web.projectslist', compact('projects'));
    }

    public function projectsshow($id)
    {
        $project = DB::table('posts')
            ->where('id', $id)
            ->first();

        if (!$project) {
            abort(404);
        }

        return view('web.projectsshow', compact('project'));
    }

    public function vendorslist()
    {
        $vendors = DB::table('vendor_reg as v')
            ->leftJoin('work_types as wt', 'wt.id', '=', 'v.work_type_id')
            ->select(
                'v.*',
                'wt.work_type as work_type_name'
            )
            ->orderBy('v.created_at', 'desc')
            ->get();

        return view('web.vendorslist', compact('vendors'));
    }

    public function supplierslist()
    {
        $supplierslist = DB::table('supplier_reg as s')
           
            ->select(
                's.*'
                
            )
            ->orderBy('s.created_at', 'desc')
            ->get();
// dd($supplierslist );
        return view('web.supplierslist', compact('supplierslist'));
    }

    public function vendorsshow($id)
    {
        $vendor = DB::table('vendor_reg as v')
            ->leftJoin('work_types as wt', 'wt.id', '=', 'v.work_type_id')
            ->leftJoin('work_subtypes as wst', 'wst.id', '=', 'v.work_subtype_id')
           
            ->select(
                'v.*',
                'wt.work_type as work_type_name',
                'wst.work_subtype as work_subtype_name'
              
            )
            ->where('v.id', $id)
            ->first();

        if (!$vendor) {
            abort(404);
        }

        return view('web.vendorshow', compact('vendor'));
    }


    public function suppliersshow($id)
    {
        $supplier = DB::table('supplier_reg as s')
            ->leftJoin('experience_years as ey', 'ey.id', '=', 's.years_in_business')
            ->select(
                's.*','ey.experiance as experiance_year'
            )
            ->where('s.id', $id)
            ->first();
// dd($supplier);
        if (!$supplier) {
            abort(404);
        }

        return view('web.suppliersshow', compact('supplier'));
    }

    public function suppliersdestroy($id)
    {
        $supplier = DB::table('supplier_reg')->where('id', $id)->first();
        return response()->json([
            'status' => true,
            'message' => 'Supplier deleted successfully'
        ]);
    }


    public function customerprofileid($id)
    {
        
        $vendor_id  = session('vendor_id');
     
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
        $customer_data = DB::table('posts as p')
                        ->leftJoin('users as u', 'u.id', '=', 'p.user_id')
                        ->leftJoin('work_types as wt', 'wt.id', '=', 'p.work_type_id')
                        ->leftJoin('state as s', 's.id', '=', 'p.state')
                        ->leftJoin('region as r', 'r.id', '=', 'p.region')
                        ->leftJoin('city as c', 'c.id', '=', 'p.city')
                        ->where('p.id', $id)
                        ->select(
                            'p.*',
                            'u.name as user_name',      // pick only needed user columns
                            'u.email as user_email',    // example
                            'u.id as cust_id',          // alias user id
                            'wt.work_type as work_typename',
                            's.name as statename',
                            'r.name as regionname',
                            'c.name as cityname'
                        )
                        ->first();

    //  dd($customer_data);
        $workSubtypes = [];
        if (!empty($customer_data->work_subtype_id)) {
            $subtypeIds = json_decode($customer_data->work_subtype_id, true);

            if (is_array($subtypeIds) && count($subtypeIds)) {
                $workSubtypes = DB::table('work_subtypes')
                    ->whereIn('id', $subtypeIds)
                    ->pluck('work_subtype')
                    ->toArray();
            }
        }

        $freeLeadPlatforms = DB::table('free_lead_requests')
                            ->where('vendor_id', $vendor_id)
                            ->whereIn('platform', ['instagram','facebook'])
                            ->pluck('platform')
                            ->toArray();
            //  dd($customer_data);           
        return view('web.customer-profile', compact('customer_data','freeLeadPlatforms','workSubtypes','vendor','vendor_id','notifications','notificationCount'));
        // dd($customer_data);
      
    }


    public function postsubscription(){
        
        $customer_id = Session::get('customer_id');
        $cust_data = DB::table('users')->where('id',$customer_id)->first();
         $postIds = DB::table('posts')
                    ->where('user_id', $customer_id)
                    ->pluck('id');
         $notifications = DB::table('vendor_interests as vi')
                // ->join('vendor_reg as v', 'v.id', '=', 'vi.vendor_id')
                ->whereIn('vi.customer_id', $postIds)
            
                ->get();
        $notificationCount = $notifications->count();
        return view('web.postsubscription',compact('cust_data','notifications','notificationCount'));
    }

    public function afterProjectPayment(Request $request)
    {
        $custId = $request->cust_id;

        // Example: increment subscription count
        DB::table('users')
            ->where('id', $custId)
            ->increment('subscription_count', 1);
        return response()->json(['success' => true]);
    }



    public function productenquirystore(Request $request)
    {
        // dd($request);
        $u_id = $request->customer_id
            ? 'c_' . $request->customer_id
            : 'v_' . $request->vendor_id;

        $cart = json_decode($request->cart_data, true);

        if (!is_array($cart) || count($cart) === 0) {
            return back()->with('error', 'Cart is empty');
        }

        DB::beginTransaction();

        try {

            $subTotal = 0;
            $gstTotal = 0;

            $enquiryId = DB::table('supplier_enquiries')->insertGetId([
                'supplier_id'       => $request->supplier_id,
                'user_id'           => $u_id,
                'delivery_location' => $request->delivery_location,
                'required_by'       => $request->required_by,
                'status'            => 'pending',
                'created_at'        => now(),
                'updated_at'        => now(),
            ]);

            foreach ($cart as $item) {
    // dd($item);
                $price   = (float) $item['price'];
                $qty     = (int)   $item['qty'];
                $gstPerc = (float) ($item['gst_percent'] ?? 0);

                $amount    = $price * $qty;
                $gstAmount = ($amount * $gstPerc) / 100;
                $total     = $amount + $gstAmount;

                $subTotal += $amount;
                $gstTotal += $gstAmount;

                DB::table('supplier_enquiry_items')->insert([
                    'enquiry_id' => $enquiryId,

                    'category_id'=> $item['category_id'] ?? null,
                    'product_id' => $item['product_id'] ?? null,
                    'spec_id'    => $item['spec_id'] ?? null,
                    'brand_id'   => $item['brand_id'] ?? null,

                    'price'       => (string) $price,
                    'qty'         => $qty,
                    'amount'      => (string) $amount,
                    'gst_percent' => (string) $gstPerc,
                    'gst_amount'  => (string) $gstAmount,
                    'total'       => (string) $total,

                    'created_at'  => now(),
                    'updated_at'  => now(),
                ]);
            }

            DB::table('supplier_enquiries')
                ->where('id', $enquiryId)
                ->update([
                    'sub_total'   => (string) $subTotal,
                    'gst_total'   => (string) $gstTotal,
                    'grand_total' => (string) ($subTotal + $gstTotal),
                    'updated_at'  => now(),
                ]);

            DB::commit();

            return redirect()
                ->route('supplier.enquiry.index')
                ->with('success', 'Enquiry sent successfully');

        } catch (\Exception $e) {
            DB::rollBack();
            // dd($e->getMessage());
            return back()->with('error', 'Failed to save enquiry');
        }
    }


     public function viewcustQuotation(){

    }
     // View quotation
    // public function viewQuotation($enquiry_id)
    // {
    //     $quotationItems = DB::table('quotations')
    //         ->where('enquiry_id', $enquiry_id)
    //         ->get();

    //     abort_if($quotationItems->isEmpty(), 404);

    //     $enquiry = DB::table('supplier_enquiries')
    //         ->where('id', $enquiry_id)
    //         ->first();

    //     return view('customer.view-quotation', compact('quotationItems', 'enquiry'));
    // }

    // Accept / Reject
    // public function quotationAction(Request $request)
    // {
    //     $request->validate([
    //         'enquiry_id' => 'required',
    //         'action'     => 'required|in:accepted,rejected',
    //     ]);

    //     DB::table('quotations')
    //         ->where('enquiry_id', $request->enquiry_id)
    //         ->update([
    //             'status' => $request->action,
    //             'customer_response_at' => now()
    //         ]);

    //     return redirect()
    //         ->back()
    //         ->with('success', 'Your response has been recorded.');
    // }



}
