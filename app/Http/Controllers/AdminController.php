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

    public function vendorsapproved($id){
         $vendor = DB::table('vendor_reg as v')
            ->leftJoin('work_types as wt', 'wt.id', '=', 'v.work_type_id')
            ->leftJoin('work_subtypes as wst', 'wst.id', '=', 'v.work_subtype_id')
            // ->leftJoin('states as s', 's.id', '=', 'v.state')
            // ->leftJoin('regions as r', 'r.id', '=', 'v.region')
            // ->leftJoin('cities as c', 'c.id', '=', 'v.city')
            ->select(
                'v.*',
                'wt.work_type as work_type_name',
                'wst.work_subtype as work_subtype_name'
                // 's.name as state_name',
                // 'r.name as region_name',
                // 'c.name as city_name'
            )
            ->where('v.id', $id)
            ->first();


        return view('web.vendorsapproved', compact('vendor'));
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
}