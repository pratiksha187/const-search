<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;

class AdminController extends Controller
{
    public function vendor_verification(){
        // dd('test');
        $vendors = DB::table('vendor_reg as v')
            ->leftJoin('work_types as wt', 'wt.id', '=', 'v.work_type_id')
            ->select(
                'v.*',
                'wt.work_type as work_type_name'
            )
            ->orderBy('v.created_at', 'desc')
            ->get();
            // dd($vendors);
        return view('web.vendor_verification', compact('vendors'));
    }

     public function supplier_verification(){
        // dd('test');
        $supplier = DB::table('supplier_reg as s')
            
            ->select(
                's.*'
               
            )
            ->orderBy('s.created_at', 'desc')
            ->get();
            // dd($vendors);
        return view('web.supplier_verification', compact('supplier'));
    }
    public function vendorsapproved($id){
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


        return view('web.vendorsapproved', compact('vendor'));
    }

     public function supplierapproved($id){
         $supplier = DB::table('supplier_reg as s')
            
            ->select(
                's.*'
               
               
            )
            ->where('s.id', $id)
            ->first();


        return view('web.supplierapproved', compact('supplier'));
    }

    
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:approve,reject'
        ]);

        // 1 = Approved, 2 = Rejected
        $statusValue = ($request->status === 'approve') ? 1 : 2;

        $updated = DB::table('vendor_reg')
            ->where('id', $id)
            ->update([
                'requerd_documnet_approve' => $statusValue,
                'updated_at' => now()
            ]);

        // Optional safety check
        if (!$updated) {
            return redirect()->back()->with('error', 'Vendor not found or already updated.');
        }

        return redirect()->back()->with(
            'success',
            $request->status === 'approve'
                ? 'Vendor approved successfully.'
                : 'Vendor rejected successfully.'
        );
    }

    public function updatesupplierStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:approve,reject'
        ]);

        // 1 = Approved, 2 = Rejected
        $statusValue = ($request->status === 'approve') ? 1 : 2;

        $updated = DB::table('supplier_reg')
            ->where('id', $id)
            ->update([
                'status' => $statusValue,
                'updated_at' => now()
            ]);

        // Optional safety check
        if (!$updated) {
            return redirect()->back()->with('error', 'supplier not found or already updated.');
        }

        return redirect()->back()->with(
            'success',
            $request->status === 'approve'
                ? 'supplier approved successfully.'
                : 'supplier rejected successfully.'
        );
    }
    

    public function uploadFreeLead(Request $request)
    {
        $vendor_id = session('vendor_id');

        if (!$vendor_id) {
            return back()->with('error', 'Session expired. Please login again.');
        }

        /* ================= VALIDATION ================= */
        $request->validate([
            'platform'   => 'required|in:instagram,facebook',
            'screenshot' => 'required|image|mimes:jpg,jpeg,png|max:20480', // 20MB
        ]);

        /* ================= STORE FILE ================= */
        $path = $request->file('screenshot')
            ->store("free_leads/{$vendor_id}", 'public');

        /* ================= SAVE REQUEST ================= */
        DB::table('free_lead_requests')->insert([
            'vendor_id'  => $vendor_id,
            'platform'   => $request->platform,
            'screenshot' => $path,
            'status'     => 'pending',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return back()->with('success', 'Screenshot uploaded successfully. Free lead will be added after verification ✅');
    }


    public function freeLeadList()
    {
        $requests = DB::table('free_lead_requests as fl')
            ->join('vendor_reg as v', 'v.id', '=', 'fl.vendor_id')
            ->select(
                'fl.*',
                'v.company_name',
                'v.mobile'
            )
            ->orderBy('fl.id', 'desc')
            ->get();

        return view('web.free_leads', compact('requests'));
    }

    
    public function freeLeadAction(Request $request, $id)
    {
        $request->validate([
            'action' => 'required|in:approve,reject'
        ]);

        $freeLead = DB::table('free_lead_requests')->where('id', $id)->first();

        if (!$freeLead || $freeLead->status !== 'pending') {
            return back()->with('error', 'Invalid or already processed request');
        }

        if ($request->action === 'approve') {

            // Credit 1 lead
            DB::table('vendor_reg')
                ->where('id', $freeLead->vendor_id)
                ->increment('lead_balance', 1);

            $status = 'approved';

        } else {
            $status = 'rejected';
        }

        // Update free lead request status
        DB::table('free_lead_requests')
            ->where('id', $id)
            ->update([
                'status' => $status,
                'updated_at' => now()
            ]);

        return back()->with(
            'success',
            'Free lead request '.$status.' successfully ✅'
        );
    }

    // public function postverification(){
    //     $work_types = DB::table('work_types')->get();
    //     $states = DB::table('state')->orderBy('name')->get();
    //     $budget_range = DB::table('budget_range')->get();
    //     $posts = DB::table('posts')
    //         ->leftJoin('budget_range', 'posts.budget_id', '=', 'budget_range.id')
    //         ->leftJoin('work_types', 'posts.work_type_id', '=', 'work_types.id')
    //         ->leftJoin('work_subtypes', 'posts.work_subtype_id', '=', 'work_subtypes.id')
    //         ->leftJoin('region', 'region.id', '=', 'posts.region')
    //         ->leftJoin('city', 'city.id', '=', 'posts.city')
    //         ->leftJoin('state', 'state.id', '=', 'posts.state')
    //         ->select(
    //                 'posts.*',

    //                 // ✅ IMPORTANT: SEND IDS TO FRONTEND
    //                 'posts.state as state_id',
    //                 'posts.region as region_id',
    //                 'posts.city as city_id',
                    

    //                 // Names (for table display)
    //                 'state.name as statename',
    //                 'region.name as regionname',
    //                 'city.name as cityname',

    //                 'work_types.work_type as work_type_name',
    //                 'work_subtypes.work_subtype as work_subtype_name',

    //                 // ✅ IMPORTANT FOR EDIT BUDGET
    //                 'posts.budget_id as budget_id',
    //                 'budget_range.budget_range as budget_range'
    //             )
               
    //             ->orderBy('posts.id', 'DESC')
    //             ->get();
    //     return view('web.verification_post',compact('posts','work_types','states','budget_range'));
    // }


    // public function postverification()
    // {
    //     $work_types = DB::table('work_types')->get();
    //     $states = DB::table('state')->orderBy('name')->get();
    //     $budget_range = DB::table('budget_range')->get();

    //     $posts = DB::table('posts')
    //         ->leftJoin('budget_range', 'posts.budget_id', '=', 'budget_range.id')
    //         ->leftJoin('work_types', 'posts.work_type_id', '=', 'work_types.id')
    //         ->leftJoin('work_subtypes', 'posts.work_subtype_id', '=', 'work_subtypes.id')
    //         ->leftJoin('region', 'region.id', '=', 'posts.region')
    //         ->leftJoin('city', 'city.id', '=', 'posts.city')
    //         ->leftJoin('state', 'state.id', '=', 'posts.state')
    //         ->select(
    //             'posts.*',
    //             'state.name as statename',
    //             'region.name as regionname',
    //             'city.name as cityname',
    //             'work_types.work_type as work_type_name',
    //             'work_subtypes.work_subtype as work_subtype_name',
    //             'budget_range.budget_range'
    //         )
    //         ->orderBy('posts.id', 'DESC')
    //         ->paginate(10);   // ✅ REQUIRED


    //     return view('web.verification_post', compact(
    //         'posts',
    //         'work_types',
    //         'states',
    //         'budget_range'
    //     ));
    // }
public function postverification(Request $request)
{
    $work_types = DB::table('work_types')->get();
    $states = DB::table('state')->orderBy('name')->get();
    $budget_range = DB::table('budget_range')->get();

    $query = DB::table('posts')
        ->leftJoin('budget_range', 'posts.budget_id', '=', 'budget_range.id')
        ->leftJoin('work_types', 'posts.work_type_id', '=', 'work_types.id')
        ->leftJoin('work_subtypes', 'posts.work_subtype_id', '=', 'work_subtypes.id')
        ->leftJoin('region', 'region.id', '=', 'posts.region')
        ->leftJoin('city', 'city.id', '=', 'posts.city')
        ->leftJoin('state', 'state.id', '=', 'posts.state')
        ->select(
            'posts.*',
            'state.name as statename',
            'region.name as regionname',
            'city.name as cityname',
            'work_types.work_type as work_type_name',
            'work_subtypes.work_subtype as work_subtype_name',
            'budget_range.budget_range'
        )
        ->orderBy('posts.id', 'DESC');

    // 🔍 SEARCH
    if ($request->filled('search')) {
        $search = $request->search;

        $query->where(function ($q) use ($search) {
            $q->where('posts.title', 'like', "%{$search}%")
              ->orWhere('work_types.work_type', 'like', "%{$search}%")
              ->orWhere('state.name', 'like', "%{$search}%")
              ->orWhere('region.name', 'like', "%{$search}%")
              ->orWhere('city.name', 'like', "%{$search}%");
        });
    }

    $posts = $query->paginate(10)->withQueryString();

    return view('web.verification_post', compact(
        'posts',
        'work_types',
        'states',
        'budget_range'
    ));
}

   
   public function verifyPost(Request $request, $id)
{
    $request->validate([
        'post_verify' => 'required|in:0,1',
    ]);

    $updated = DB::table('posts')
        ->where('id', $id)
        ->update([
            'post_verify' => $request->post_verify,
            'updated_at' => now()
        ]);

    return back()->with(
        $updated ? 'success' : 'error',
        $updated
            ? 'Project status updated successfully.'
            : 'No changes were made.'
    );
}


   
}