<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{
    public function homepage(){
        
         $vendors = DB::table('vendor_reg')->count();
        //  $cities =DB::connection('mysql2')->table('cities')->count();
         $posts= DB::table('posts')->count();
        //  dd( $vendors);
        return view('welcome',compact('vendors','posts'));
    }

    public function index()
    {
        $user_id = session('user_id');
        $work_types = DB::table('work_types')->get();
        $projecttype = DB::table('projecttype')->get();
        $posts = DB::table('posts')
            ->leftJoin('projecttype', 'posts.project_type_id', '=', 'projecttype.id')
            ->leftJoin('budget_range', 'posts.budget_id', '=', 'budget_range.id')
            ->leftJoin('work_types', 'posts.work_type_id', '=', 'work_types.id')
            ->leftJoin('work_subtypes', 'posts.project_type_id', '=', 'work_subtypes.id')
           
            ->select(
                'posts.*',
                'work_types.work_type as work_type_name',
                'projecttype.projecttype_name',
                'budget_range.budget_range as budget_range'
               
            )

            ->where('posts.user_id', $user_id)
            ->groupBy(
                'posts.id',
                'projecttype.projecttype_name',
                'budget_range.budget_range'
            )
            ->orderBy('posts.id', 'DESC')
            ->paginate(10);   // ✅ Pagination

        return view('web.my-posts', compact('posts','work_types'));
    }

    public function post(){
        $work_types = DB::table('work_types')->get();
        $projecttype = DB::table('projecttype')->get();
        $budget_range = DB::table('budget_range')->get();
        // $states = DB::connection('mysql2')->table('states')->get();
        return view('web.post',compact('projecttype','budget_range','work_types'));
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
        $regions = DB::connection('mysql2')
            ->table('regions')
            ->where('states_id', $state_id)
            ->get();

        return response()->json($regions);
    }

    public function getCities($region_id)
    {
        $cities = DB::connection('mysql2')
            ->table('cities')
            ->where('regions_id', $region_id)
            ->get();

        return response()->json($cities);
    }
  
  
    public function cutomerprofile()
    {
        $user_id = Session::get('user_id');

        

        $user = DB::table('users')->where('id', $user_id)->first();

        return view('web.cutomerprofile', compact('user'));
    }
    
   
    public function cutomerupdate(Request $request)
    {
        $user_id = Session::get('user_id');

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

        DB::table('users')->where('id', $user_id)->update($data);

        return back()->with('success', 'Profile updated successfully');
    }

    public function search_vendor(Request $request)
    {
        $user_id = Session::get('user_id');

        $work_types = DB::table('work_types')->get();

        // 🔹 ADD THIS
        $work_subtypes = DB::table('work_subtypes')
            ->get()
            ->groupBy('work_type_id');

        $vendor_reg = DB::table('vendor_reg')
            ->leftJoin('work_types', 'work_types.id', '=', 'vendor_reg.work_type')
            ->select('vendor_reg.*', 'work_types.work_type as work_type')
            ->get();

        foreach ($vendor_reg as $vendor) {
            $subtypeIds = json_decode($vendor->work_subtype ?? '[]', true);

            $vendor->work_subtype_names = is_array($subtypeIds)
                ? DB::table('work_subtypes')->whereIn('id', $subtypeIds)->pluck('work_subtype')->implode(', ')
                : '';
        }

        return view('web.search_vendor', compact(
            'vendor_reg',
            'work_types',
            'work_subtypes'
        ));
    }

    public function search_vendor_post(Request $request)
    {
        /* ===============================
        MASTER DATA
        =============================== */
        $projecttype = DB::table('projecttype')->get();
        $work_types  = DB::table('work_types')->get();
        // $states      = DB::connection('mysql2')->table('states')->get();
        $budgets     = DB::table('budget_range')->get();

        /* ===============================
        FILTER VALUES (FOR REFILL)
        =============================== */
        $filters = [
            'state'    => $request->state ?? '',
            'region'   => $request->region ?? '',
            'city'     => $request->city ?? '',
            'type'     => $request->type ?? '',
            'category' => $request->category ?? [],
            'budget'   => $request->budget ?? [],
            'rating'   => $request->rating ?? [],
        ];

        /* ===============================
        BASE QUERY (vendor_reg)
        =============================== */
        $query = DB::table('vendor_reg')
            ->leftJoin('work_types', 'work_types.id', '=', 'vendor_reg.work_type')
            ->select(
                'vendor_reg.*',
                'work_types.work_type as work_type'
            );

        /* ===============================
        APPLY FILTERS
        =============================== */

        if (!empty($filters['type'])) {
            $query->where('vendor_reg.work_type', $filters['type']);
        }

        if (!empty($filters['category'])) {
            $query->whereIn('vendor_reg.work_type', $filters['category']);
        }

        if (!empty($filters['state'])) {
            $query->where('vendor_reg.state', $filters['state']);
        }

        if (!empty($filters['region'])) {
            $query->where('vendor_reg.region', $filters['region']);
        }

        if (!empty($filters['city'])) {
            $query->where('vendor_reg.city', $filters['city']);
        }

        // Budget filter (example: min_budget / max_budget columns)
        if (!empty($filters['budget'])) {
            $query->where(function ($q) use ($filters) {
                foreach ($filters['budget'] as $range) {
                    [$min, $max] = explode('-', $range);
                    $q->orWhereBetween('vendor_reg.min_project_price', [$min, $max]);
                }
            });
        }

        /* ===============================
        EXECUTE QUERY
        =============================== */
        $vendor_reg = $query->distinct()->get();

        /* ===============================
        WORK SUBTYPE (JSON SAFE)
        =============================== */
        foreach ($vendor_reg as $vendor) {

            $subtypeIds = json_decode($vendor->work_subtype ?? '[]', true);

            if (is_array($subtypeIds) && count($subtypeIds) > 0) {
                $vendor->work_subtype_names = DB::table('work_subtypes')
                    ->whereIn('id', $subtypeIds)
                    ->pluck('work_subtype')
                    ->implode(', ');
            } else {
                $vendor->work_subtype_names = '';
            }
        }

        /* ===============================
        AJAX RESPONSE (OPTIONAL)
        =============================== */
        if ($request->ajax()) {
            return view('web.partials.vendor_cards', compact('vendor_reg'))->render();
        }

        /* ===============================
        RETURN VIEW (IMPORTANT)
        =============================== */
        return view('web.search_vendor', compact(
            'vendor_reg',
            'work_types',
            // 'states',
            'projecttype',
            'budgets',
            'filters'
        ));
    }

    public function vendorinterestcheck(Request $request)
    {
      
        $cust_id   = $request->cust_id;
        
        $vendor_id = Session::get('vendor_id');
        // dd($vendor_id);
        if (!$vendor_id) {
            return response()->json([
                'error' => 'Unauthorized'
            ], 401);
        }

        // Count used leads BEFORE insert
        $usedLeads = DB::table('vendor_interests')
            ->where('vendor_id', $vendor_id)
            ->where('customer_id', $cust_id)

            ->count();
       
       
        if ($usedLeads >= 5) {
            return response()->json([
                'payment_required' => true,
                'remaining' => 0
            ]);
        }

        // Prevent duplicate vendor interest
        $already = DB::table('vendor_interests')
            ->where('customer_id', $cust_id)
            ->where('vendor_id', $vendor_id)
            ->exists();

        if (!$already) {
            DB::table('vendor_interests')->insert([
                'customer_id' => $cust_id,
                'vendor_id'   => $vendor_id,
                'created_at'  => now()
            ]);
        }

        $remaining = 5 - ($usedLeads + 1);

        return response()->json([
            'success' => true,
            'payment_required' => false,
            'remaining' => max(0, $remaining)
        ]);
    }

    public function search_customer(Request $request)
    {
        $vendor_id = Session::get('vendor_id');
        // dd($vendor_id);
        $work_types = DB::table('work_types')->get();
        $work_subtypes = DB::table('work_subtypes')
                        ->get()
                        ->groupBy('work_type_id');
        
        $projects = DB::connection('mysql')
            ->table('posts')
            ->leftJoin('projecttype', 'projecttype.id', '=', 'posts.project_type_id')
            ->leftJoin('budget_range', 'budget_range.id', '=', 'posts.budget_id')
            ->select(
                'projecttype.projecttype_name',
                'posts.*',
                'budget_range.budget_range as budget_range_name'
               
            )
            ->orderBy('posts.id', 'desc')
            ->get();

        return view('web.search_customer', [
            'work_types' => $work_types,
            'projects' => $projects, 
            'vendor_id' => $vendor_id,
            'filters' => []        
        ]);
    }

    // public function search_customer_post(Request $request)
    // {
    //     // Dropdown Data
    //     $work_types = DB::connection('mysql')->table('projecttype')->get();
    //     // $states = DB::connection('mysql2')->table('states')->get();

    //     // Base Query
    //     $query = DB::connection('mysql')
    //         ->table('posts')
    //         ->leftJoin('projecttype', 'projecttype.id', '=', 'posts.project_type_id')
    //         ->leftJoin('budget_range', 'budget_range.id', '=', 'posts.budget_id')
    //         // ->leftJoin(DB::raw('buildxo_web.states'), 'posts.state', '=', 'states.id')
    //         // ->leftJoin(DB::raw('buildxo_web.regions'), 'posts.region', '=', 'regions.id')
    //         // ->leftJoin(DB::raw('buildxo_web.cities'), 'posts.city', '=', 'cities.id')
    //         ->select(
    //             'projecttype.projecttype_name',
    //             'posts.*',
    //             'budget_range.budget_range as budget_range_name'
    //             // 'states.name as state_name',
    //             // 'regions.name as regionsname',
    //             // 'cities.name as citiesname'
    //         );

    //     // 🔍 Apply Filters When Searching
    //     if ($request->state) {
    //         $query->where('posts.state', $request->state);
    //     }

    //     if ($request->region) {
    //         $query->where('posts.region', $request->region);
    //     }

    //     if ($request->city) {
    //         $query->where('posts.city', $request->city);
    //     }

    //     if ($request->category) {
    //         $query->whereIn('posts.project_type_id', $request->category);
    //     }

    //     // Execute query and get projects
    //     $projects = $query->get();

    //     return view('web.search_customer', [
    //         // 'states' => $states,
    //         'work_types' => $work_types,
    //         'projects' => $projects,
    //         'filters' => $request->all()  // Keep selected values
    //     ]);
    // }

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
        $request->validate([
            'title'           => 'required|string|max:255',
            'work_type_id'    => 'required|integer',
            'project_type_id' => 'required|integer',
            'state'           => 'nullable|string',
            'region'          => 'nullable|string',
            'city'            => 'nullable|string',
            'budget'          => 'required|integer',
            'contact_name'    => 'required|string|max:255',
            'mobile'          => 'required|string|max:20',
            'email'           => 'required|email',
            'description'     => 'required|string',
        ]);

        $uploadedFiles = [];

        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $filename = time().'_'.uniqid().'.'.$file->getClientOriginalExtension();
                $file->move(public_path('uploads/posts'), $filename);
                $uploadedFiles[] = $filename;
            }
        }

        DB::table('posts')->insert([
            'user_id'         => session('user_id'),
            'title'           => $request->title,
            'work_type_id'    => $request->work_type_id,
            'project_type_id' => $request->project_type_id,
            'state'           => $request->state,
            'region'          => $request->region,
            'city'            => $request->city,
            'budget_id'       => $request->budget,
            'contact_name'    => $request->contact_name,
            'mobile'          => $request->mobile,
            'email'           => $request->email,
            'description'     => $request->description,
            'files'           => json_encode($uploadedFiles),
            'created_at'      => now(),
            'updated_at'      => now(),
        ]);

        return redirect()
            ->route('myposts')
            ->with('success', 'Project Posted Successfully!');
    }

   
    public function leadmarketplace(){
        return view('web.lead_marketplace');
    }


    public function saveSiteVisit(Request $request)
    {
        DB::table('site_visits')->insert([
            'customer_id' => Session::get('user_id'),
            'vendor_id'   => $request->vendor_id,
            'visit_date'  => $request->visit_date,
            'visit_time'  => $request->visit_time,
            'created_at'  => now(),
        ]);

        // Create notification
        DB::table('vendor_notifications')->insert([
            'vendor_id' => $request->vendor_id,
            'title'     => 'New Site Visit Booked',
            'message'   => 'A customer has booked a site visit on ' . $request->visit_date . ' at ' . $request->visit_time,
            'created_at'=> now()
        ]);

        return response()->json([
            'status'  => true,
            'message' => 'Slot booked successfully!'
        ]);
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


    public function userNotifications()
    {
        // $vendor_id = Session::get('user_id');
        $user_id = Session::get('user_id');
        // dd($user_id);
        $usernotifications = DB::table('customer_notifications')
            ->where('customer_id', $user_id)
            ->orderBy('id', 'DESC')
            ->get();
            // dd( $notifications);
        return view('web.usernotifications', compact('usernotifications'));
    }

    public function readVendorNotification($id)
    {
        $vendor_id = Session::get('user_id');

        DB::table('vendor_notifications')
            ->where('id', $id)
            ->where('vendor_id', $vendor_id)
            ->update(['is_read' => 1]);

        return redirect()->back()->with('success', 'Notification marked as read.');
    }

    public function getProjectDetails(Request $request)
    {
        $id = $request->id;

        $project = DB::connection('mysql')
            ->table('posts')
            ->leftJoin('projecttype', 'projecttype.id', '=', 'posts.project_type_id')
            ->leftJoin('budget_range', 'budget_range.id', '=', 'posts.budget_id')
            // ->leftJoin(DB::raw('buildxo_web.states'), 'posts.state', '=', 'states.id')
            // ->leftJoin(DB::raw('buildxo_web.regions'), 'posts.region', '=', 'regions.id')
            // ->leftJoin(DB::raw('buildxo_web.cities'), 'posts.city', '=', 'cities.id')
            ->select(
                'posts.*',
                'projecttype.projecttype_name as type',
                'budget_range.budget_range as budget'
                // 'states.name as state',
                // 'regions.name as region',
                // 'cities.name as city'
            )
            ->where('posts.id', $id)
            ->first();

        return response()->json([
            'title' => $project->title,
            'type' => $project->type,
            'budget' => $project->budget,
            'contact' => $project->contact_name,
            'mobile' => $project->mobile,
            'email' => $project->email,
            'description' => $project->description,
            'state' => $project->state,
            'region' => $project->region,
            'city' => $project->city,
            'files' => json_decode($project->files, true) ?? []
        ]);
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
    $vendor_id = Session::get('user_id'); // your logged-in user id

    $request->validate([
        'title'       => 'required|string|max:255',
        'budget'      => 'nullable|string|max:255',
        'description' => 'nullable|string',
    ]);

    // ✅ update only the user's own post
    $updated = DB::table('posts')
        ->where('id', $id)               // ✅ post id
        ->where('user_id', $vendor_id)   // ✅ owner check
        ->update([
            'title'        => $request->title,
           
            'description'  => $request->description,
            'updated_at'   => now(),
        ]);

    if (!$updated) {
        return redirect()->back()->with('error', 'Post not found or you are not allowed to update it.');
    }

    return redirect()->back()->with('success', 'Post updated successfully');
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


}
