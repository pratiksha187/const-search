<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

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

}