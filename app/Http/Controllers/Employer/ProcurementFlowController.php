<?php

namespace App\Http\Controllers\Employer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProcurementFlowController extends Controller
{
    public function page($projectId)
    {
        $project = DB::table('projects')->where('id', $projectId)->first();
        if(!$project){
            abort(404, 'Project not found');
        }

        $rfq = DB::table('rfqs')->where('project_id', $projectId)->orderByDesc('id')->first();

        return view('web.employers.sourcing_flow', compact('project','rfq'));
    }

    // ✅ Step2: create RFQ (REMOVE dd)
    public function createRfq(Request $request)
    {
        $data = $request->validate([
            'project_id' => 'required|integer',
            'title' => 'required|string|max:255',
            'deadline' => 'nullable|date',
            'payment_terms' => 'nullable|string|max:255',
        ]);

        $id = DB::table('rfqs')->insertGetId([
            'project_id' => $data['project_id'],
            'title' => $data['title'],
            'deadline' => $data['deadline'] ?? null,
            'payment_terms' => $data['payment_terms'] ?? null,
            'status' => 'open', // ✅ use open/draft etc
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return response()->json(['ok' => true, 'rfq_id' => $id]);
    }

    public function acceptedVendors($projectId)
    {
        $vendors = DB::table('vendor_pqc_submissions as vps')
            ->join('vendor_reg as v', 'v.id', '=', 'vps.vendor_id')
            ->where('vps.project_id', $projectId)
            ->where('vps.accept_status', 'accepted')
            ->select('v.id','v.company_name','v.name','v.mobile')
            ->distinct()
            ->get();

        return response()->json(['ok'=>true,'vendors'=>$vendors]);
    }

    public function inviteVendor(Request $request)
    {
        $data = $request->validate([
            'rfq_id' => 'required|integer',
            'vendor_id' => 'required|integer',
        ]);

        DB::connection('tenant')->table('rfq_vendors')->updateOrInsert(
            ['rfq_id' => $data['rfq_id'], 'vendor_id' => $data['vendor_id']],
            ['invited_at' => now(), 'status' => 'invited', 'updated_at'=>now(), 'created_at'=>now()]
        );

        return response()->json(['ok'=>true]);
    }

    public function invitedVendors($rfqId)
    {
        $rows = DB::connection('tenant')->table('rfq_vendors as rv')
            // ->join('vendor_reg as v','v.id','=','rv.vendor_id')
            ->where('rv.rfq_id', $rfqId)
            // ->select('v.id','v.company_name','v.name','v.mobile','rv.status','rv.invited_at')
            ->orderByDesc('rv.id')
            ->get();

        return response()->json(['ok'=>true,'vendors'=>$rows]);
    }

    public function submitBid(Request $request)
    {
        $data = $request->validate([
            'rfq_id' => 'required|integer',
            'vendor_id' => 'required|integer',
            'total_quote' => 'required|numeric|min:0',
            'delivery_timeline' => 'nullable|string|max:120',
            'terms' => 'nullable|string',
        ]);

        $invited = DB::connection('tenant')->table('rfq_vendors')
            ->where('rfq_id', $data['rfq_id'])
            ->where('vendor_id', $data['vendor_id'])
            ->exists();

        if(!$invited){
            return response()->json(['ok'=>false,'message'=>'Vendor not invited'], 422);
        }

        DB::connection('tenant')->table('rfq_bids')->updateOrInsert(
            ['rfq_id' => $data['rfq_id'], 'vendor_id' => $data['vendor_id']],
            [
                'total_quote' => $data['total_quote'],
                'delivery_timeline' => $data['delivery_timeline'] ?? null,
                'terms' => $data['terms'] ?? null,
                'status' => 'submitted',
                'updated_at' => now(),
                'created_at' => now(),
            ]
        );

        DB::connection('tenant')->table('rfq_vendors')
            ->where('rfq_id', $data['rfq_id'])
            ->where('vendor_id', $data['vendor_id'])
            ->update(['status'=>'responded','updated_at'=>now()]);

        return response()->json(['ok'=>true]);
    }

    public function listBids($rfqId)
    {
        $bids = DB::table('rfq_bids as b')
            ->join('vendor_reg as v','v.id','=','b.vendor_id')
            ->where('b.rfq_id', $rfqId)
            ->select('b.*','v.company_name','v.name','v.mobile')
            ->orderBy('b.total_quote','asc')
            ->get();
            

        return response()->json(['ok'=>true,'bids'=>$bids]);
    }

    public function compareBids($rfqId)
    {
        $bids = DB::table('rfq_bids as b')
            ->join('vendor_reg as v','v.id','=','b.vendor_id')
            ->where('b.rfq_id', $rfqId)
            ->select('b.vendor_id','b.total_quote','b.delivery_timeline','b.terms','v.company_name','v.name','v.mobile')
            ->orderBy('b.total_quote','asc')
            ->get();

        return response()->json(['ok'=>true,'bids'=>$bids]);
    }
}