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
         $cities =DB::table('city')->count();
         $posts= DB::table('posts')->count();
        //  dd( $vendors);
        return view('welcome',compact('vendors','posts','cities'));
    }

    public function index()
    {
        $customer_id = Session::get('customer_id');
        $cust_data = DB::table('users')->where('id',$customer_id)->first();
        $work_types = DB::table('work_types')->get();
        $work_subtypes = DB::table('work_subtypes')->get();
        $posts = DB::table('posts')
            // ->leftJoin('projecttype', 'posts.project_type_id', '=', 'projecttype.id')
            ->leftJoin('budget_range', 'posts.budget_id', '=', 'budget_range.id')
            ->leftJoin('work_types', 'posts.work_type_id', '=', 'work_types.id')
            ->leftJoin('work_subtypes', 'posts.work_subtype_id', '=', 'work_subtypes.id')
           
            ->select(
                'posts.*',
                'work_types.work_type as work_type_name',
                'work_subtypes.work_subtype',
                'budget_range.budget_range as budget_range'
               
            )

            ->where('posts.user_id', $customer_id)
            ->groupBy(
                'posts.id',
                'work_subtypes.work_subtype',
                'budget_range.budget_range'
            )
            ->orderBy('posts.id', 'DESC')
            ->paginate(10);   // ✅ Pagination
        // dd($posts);
        return view('web.my-posts', compact('posts','work_types','cust_data'));
    }

    public function post(){
        $customer_id = Session::get('customer_id');
        $cust_data = DB::table('users')->where('id',$customer_id)->first();
        $work_types = DB::table('work_types')->get();
        $states = DB::table('state')->orderBy('name')->get();

        $work_subtypes = DB::table('work_subtypes')->get();
        $budget_range = DB::table('budget_range')->get();
        // $states = DB::connection('mysql2')->table('states')->get();
        return view('web.post',compact('work_subtypes','budget_range','work_types','states','cust_data'));
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
        $customer_id = Session::get('customer_id');

      

        $user = DB::table('users')->where('id', $customer_id)->first();

        return view('web.cutomerprofile', compact('user'));
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
        // dd($customer_id);
        $work_types = DB::table('work_types')->get();
        $states = DB::table('state')->orderBy('name')->get();

        // 🔹 ADD THIS
        $work_subtypes = DB::table('work_subtypes')
                        ->get()
                        ->groupBy('work_type_id');

        $vendor_reg = DB::table('vendor_reg')
            ->leftJoin('work_types', 'work_types.id', '=', 'vendor_reg.work_type_id')
            ->leftJoin('work_subtypes', 'work_subtypes.id', '=', 'vendor_reg.work_subtype_id')
            ->leftJoin('team_size', 'team_size.id', '=', 'vendor_reg.team_size')

            ->leftJoin('region', 'region.id', '=', 'vendor_reg.region')
            ->leftJoin('state', 'state.id', '=', 'vendor_reg.state')
            ->leftJoin('city', 'city.id', '=', 'vendor_reg.state')
            
            
            ->select(
                'work_types.*',
                'team_size.team_size as team_size_data',
                'work_subtypes.*',
                'vendor_reg.*' ,
                'region.name as regionname','state.name as statename','city.name as cityname'      
            )
             ->orderBy('vendor_reg.id', 'desc')
            ->get();

        // dd($vendor_reg);
        return view('web.search_vendor', [
            'work_types' => $work_types,
            'states' => $states,
            'vendor_reg' => $vendor_reg, 
            'customer_id' => $customer_id,
            'filters' => []   
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
        $states = DB::table('state')->orderBy('name')->get();
      
        $work_types = DB::table('work_types')->get();
        $work_subtypes = DB::table('work_subtypes')
                        ->get()
                        ->groupBy('work_type_id');
        
        $projects = DB::connection('mysql')
            ->table('posts')
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
            ->orderBy('posts.id', 'desc')
            ->get();
        //    dd($projects);
        return view('web.search_customer', [
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
        $vendor_id = Session::get('vendor_id');
          
        if (!$vendor_id) {
            return response()->json([
                'error' => 'Unauthorized'
            ], 401);
        }

        // 🔢 TOTAL USED LEADS (IMPORTANT)
        $usedLeads = DB::table('vendor_interests')
            ->where('vendor_id', $vendor_id)
            ->count();
        // dd( $usedLeads );
        // 🚫 LIMIT REACHED → PAYMENT REQUIRED
        if ($usedLeads >= 5) {
            return response()->json([
                'payment_required' => true,
                'remaining' => 0
            ]);
        }

        // 🔁 Prevent duplicate interest for same customer
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


    public function customerinterestcheck(Request $request)
    {
        $vend_id     = $request->vend_id;
        // dd($vend_id);
        $customer_id = Session::get('customer_id');
        // dd($customer_id);
        if (!$customer_id) {
            return response()->json([
                'authorized' => false
            ], 401);
        }

        // Check duplicate interest
        $alreadyInterested = DB::table('customer_interests')
            ->where('customer_id', $customer_id)
            ->where('vendor_id', $vend_id)
            ->exists();
        // dd( $alreadyInterested );
        // Total used leads
        $usedLeads = DB::table('customer_interests')
            ->where('customer_id', $customer_id)
            ->count();

        // If already interested → allow access without payment
        if ($alreadyInterested) {
            return response()->json([
                'authorized'        => true,
                'payment_required'  => false,
                'remaining'         => max(0, 5 - $usedLeads)
            ]);
        }

        // Free limit reached
        if ($usedLeads >= 5) {
            return response()->json([
                'authorized'       => true,
                'payment_required' => true,
                'remaining'        => 0
            ]);
        }

        // Insert interest (consume 1 free lead)
        DB::table('customer_interests')->insert([
            'customer_id' => $customer_id,
            'vendor_id'   => $vend_id,
            'created_at'  => now()
        ]);

        return response()->json([
            'authorized'        => true,
            'payment_required' => false,
            'remaining'        => 5 - ($usedLeads + 1)
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
        // dd($customer_id);
        $request->validate([
            'title'           => 'required|string|max:255',
            'work_type_id'    => 'required|integer',
            'work_subtype_id' => 'required|integer',
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
            'user_id'         => $customer_id,
            'title'           => $request->title,
            'work_type_id'    => $request->work_type_id,
            'work_subtype_id' => $request->work_subtype_id,
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
        // dd($request);
        // $vendor_id = Session::get('user_id'); // your logged-in user id
        $customer_id = Session::get('customer_id');
        $request->validate([
            'title'       => 'required',
            'budget'      => 'nullable',
            'description' => 'nullable',
        ]);

        // ✅ update only the user's own post
        $updated = DB::table('posts')
            ->where('id', $id)               // ✅ post id
            ->where('user_id', $customer_id)   // ✅ owner check
            ->update([
                'title'        => $request->title,
                'work_type_id' =>$request->work_type_id,
                'state'=> $request->state,
                'region'=>$request->region,
                'city' => $request->city,
                'budget_id' =>$request->budget,
                'contact_name' => $request->contact_name,
                'mobile' => $request->mobile,

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

    
// public function saveErpInterest(Request $request)
// {
//     $request->validate([
//         'full_name'          => 'required|string|max:150',
//         'company_name'       => 'required|string|max:200',
//         'role_in_org'        => 'required|string|max:100',
//         'organization_type'  => 'required|string',
//         'project_size'       => 'required|string',
//         'looking_for'        => 'required|array',
//         'current_challenge'  => 'required|string',
//         'interest_level'     => 'required|string',
//         'contact_details'    => 'required|string'
//     ]);

//     DB::table('erp_interest_registrations')->insert([
//         'full_name'         => $request->full_name,
//         'company_name'      => $request->company_name,
//         'role_in_org'       => $request->role_in_org,
//         'organization_type' => $request->organization_type,
//         'project_size'      => $request->project_size,
//         'looking_for'       => json_encode($request->looking_for),
//         'current_challenge' => $request->current_challenge,
//         'interest_level'    => $request->interest_level,
//         'contact_details'   => $request->contact_details,
//         'created_at'        => now(),
//         'updated_at'        => now()
//     ]);

//     return response()->json([
//         'status' => true,
//         'message' => 'Interest registered successfully'
//     ]);
// }
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

}
