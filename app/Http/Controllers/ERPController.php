<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;

use Illuminate\Support\Facades\Session;


class ERPController extends Controller
{
    public function erp(){
        return view('web.erp');
    }

    public function erpproject(){
        $work_types = DB::connection('mysql')->table('work_types')->get();
        $states = DB::connection('mysql')->table('state')->orderBy('name')->get();
        $budget_range = DB::connection('mysql')->table('budget_range')->get();
        $unit = DB::connection('mysql')->table('cust_unit')->get();
       
        $masterDb = DB::connection('mysql')->getDatabaseName();


        $projects = DB::connection('tenant')
            ->table('projects as p')
            ->leftJoin($masterDb.'.work_types as wt', 'p.work_type_id', '=', 'wt.id')
            ->leftJoin($masterDb.'.city as c', 'p.city_id', '=', 'c.id')
             ->leftJoin($masterDb.'.work_subtypes as ws', 'p.work_subtype_id', '=', 'ws.id')
            ->leftJoin($masterDb.'.region as r', 'r.id', '=', 'p.region_id')
             ->leftJoin($masterDb.'.budget_range as b', 'p.budget', '=', 'b.id')
           
            ->leftJoin($masterDb.'.state as s', 's.id', '=', 'p.state_id')
            ->select(
                'p.*',
                'wt.work_type as type_name','b.budget_range',
                'c.name as city_name','s.name as statename',
                'r.name as regionname'
                
            )
            ->orderBy('p.id', 'desc')
            ->get();
            $projectIds = $projects->pluck('id')->toArray();
            // dd( $projectIds);
            $pqcStats = DB::table('vendor_pqc_submissions')
                ->selectRaw('project_id,
                    SUM(CASE WHEN doc_type="pqc" THEN 1 ELSE 0 END) as pqc_count,
                    SUM(CASE WHEN doc_type="company" THEN 1 ELSE 0 END) as company_count,
                    SUM(CASE WHEN status="submitted" THEN 1 ELSE 0 END) as submitted_count
                ')
                ->whereIn('project_id', $projectIds)
                ->groupBy('project_id')
                ->get()
                ->keyBy('project_id');
            // dd($projects);
        return view('web.employers.project',compact('work_types','states','budget_range','unit','projects','pqcStats'));

    }

public function storeerpproject(Request $request)
{
    // dd($request);
    $request->validate([
        'work_type_id' => 'required',
        'work_subtype_id' => 'required',
        'title' => 'required',
        'state_id' => 'required',
        'region_id' => 'required',
        'city_id' => 'required',
        'budget' => 'required',
    ]);

    $conn = DB::connection('tenant');
    $conn->beginTransaction();

    try {

        $projectCount = $conn->table('projects')->count() + 1;
        $projectCode = 'PROJ-' . str_pad($projectCount, 4, '0', STR_PAD_LEFT);

        $uploadedFiles = [];

        // Upload Files
        if ($request->hasFile('files')) {

            foreach ($request->file('files') as $file) {

                $fileName = time().'_'.Str::random(5).'_'.$file->getClientOriginalName();

                $file->move(public_path('uploads/tenant_projects'), $fileName);

                $uploadedFiles[] = 'uploads/tenant_projects/'.$fileName;
            }
        }

     
        $projectId = $conn->table('projects')->insertGetId([

            'code' => $projectCode,
            'work_type_id' => $request->work_type_id,
            'work_subtype_id' => $request->work_subtype_id,
            'title' => $request->title,
              // Location
            'state_id' => $request->state_id,
            'region_id' => $request->region_id,
            'city_id' => $request->city_id,
            // Budget
            'budget' => $request->budget ?? 0,
            'contact_name' => $request->contact_name,
            'mobile'=> $request->mobile,
            // Type Mapping
            'description' => $request->description,
            // Timeline
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,

            'created_by' => auth()->id() ?? 1,
            'status' => 'Planning',

            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $conn->commit();

        return response()->json([
            'status' => 'success',
            'message' => 'Project Created Successfully'
        ]);

    } catch (\Exception $e) {

        $conn->rollBack();

        return response()->json([
            'status' => 'error',
            'message' => $e->getMessage()
        ], 500);
    }
}
    // public function boq_rfq_bids(){
    //     return view('web.employers.boq_rfq_bids');
    // }
    public function boq_rfq_bids($projectId)
    {
        // 1) fetch project (use your actual projects table name/columns)
        $project = DB::connection('tenant')->table('projects')->where('id', $projectId)->first();
        

        if (!$project) {
            return redirect()->back()->with('error', 'Project not found.');
        }

        // 2) fetch existing rfq if you have rfqs table, else null
        $rfq =DB::connection('tenant')->table('rfqs')
            ->where('project_id', $projectId)
            ->orderByDesc('id')
            ->first();

        // dd($rfq);
        return view('web.employers.boq_rfq_bids', compact('project','rfq'));
    }


    public function rfqReplies($projectId)
{
    $rfq = DB::connection('tenant')->table('rfqs')
        ->where('project_id', $projectId)
        ->orderByDesc('id')
        ->first();

    if (!$rfq) {
        return response()->json([
            'ok' => false,
            'message' => 'RFQ not found'
        ]);
    }

    $rows = DB::connection('tenant')->table('rfq_vendor_invites as rvi')
        // ->join('const_search.vendor_reg as v', 'v.id', '=', 'rvi.vendor_id') // change if needed
        ->where('rvi.rfq_id', $rfq->id)
        ->select(
            'rvi.id',
            'rvi.rfq_id',
            'rvi.vendor_id',
            'rvi.status',
            'rvi.reply_file',
            'rvi.replied_at',
            'rvi.created_at',
            // 'v.company_name',
            // 'v.name',
            // 'v.mobile'
        )
        ->orderByDesc('rvi.id')
        ->get();

    return response()->json([
        'ok' => true,
        'rfq_id' => $rfq->id,
        'rows' => $rows
    ]);
}

    public function po_grm_invoice(){
        return view('web.employers.po_grn_invoice');
    }

    public function vendor_network(){
        return view('web.employers.vendor_network');
    }

// public function showProject($id)
// {
//     $masterDb = DB::connection('mysql')->getDatabaseName();

//     // ==============================
//     // FETCH PROJECT (Tenant DB)
//     // ==============================
//     $project = DB::connection('tenant')
//         ->table('projects as p')
//         ->leftJoin($masterDb.'.work_types as wt', 'p.work_type_id', '=', 'wt.id')
//         ->leftJoin($masterDb.'.work_subtypes as ws', 'p.work_subtype_id', '=', 'ws.id')
//         ->leftJoin($masterDb.'.city as c', 'p.city_id', '=', 'c.id')
//         ->leftJoin($masterDb.'.region as r', 'r.id', '=', 'p.region_id')
//         ->leftJoin($masterDb.'.state as s', 's.id', '=', 'p.state_id')
//         ->leftJoin($masterDb.'.budget_range as b', 'p.estimated_budget', '=', 'b.id')
//         ->select(
//             'p.*',
//             'wt.work_type as type_name',
//             'ws.work_subtype as subtype_name',
//             'c.name as city_name',
//             'r.name as regionname',
//             's.name as statename',
//             'b.budget_range'
//         )
//         ->where('p.id', $id)
//         ->first();

//     if (!$project) {
//         abort(404);
//     }

//     // ==============================
//     // FETCH MATCHING VENDORS (Master DB)
//     // ==============================

//     $vendorsQuery = DB::connection('mysql')
//         ->table('vendor_reg')
//         ->where('work_type_id', $project->work_type_id)
//         ->where('status', 'approved');

//     // Match Work Subtype (JSON column)
//     if (!empty($project->work_subtype_id)) {
//         $vendorsQuery->whereRaw(
//             "JSON_CONTAINS(work_subtype_id, ?)",
//             ['"' . $project->work_subtype_id . '"']
//         );
//     }

//     // Smart Location Matching (City → Region → State)
//     if (!empty($project->city_id)) {

//         $vendorsQuery->where(function ($query) use ($project) {
//             $query->where('city', $project->city_id)
//                   ->orWhere('region', $project->region_id)
//                   ->orWhere('state', $project->state_id)
//                   ->orWhereNull('state');
//         });
//     }

//     $vendors = $vendorsQuery
//         ->orderByDesc('experience_years')
//         ->orderByDesc('lead_balance')
//         ->get();

//     return view('web.employers.project_details', compact('project', 'vendors'));
// }

public function showProject($id)
{
    $masterDb = DB::connection('mysql')->getDatabaseName();

    $project = DB::connection('tenant')
        ->table('projects as p')
        ->leftJoin($masterDb.'.work_types as wt', 'p.work_type_id', '=', 'wt.id')
        ->leftJoin($masterDb.'.work_subtypes as ws', 'p.work_subtype_id', '=', 'ws.id')
        ->leftJoin($masterDb.'.city as c', 'p.city_id', '=', 'c.id')
        ->leftJoin($masterDb.'.region as r', 'r.id', '=', 'p.region_id')
        ->leftJoin($masterDb.'.state as s', 's.id', '=', 'p.state_id')
        ->leftJoin($masterDb.'.budget_range as b', 'p.budget', '=', 'b.id') // ✅ FIXED
        ->select(
            'p.*',
            'wt.work_type as type_name',
            'ws.work_subtype as subtype_name',
            'c.name as city_name',
            'r.name as regionname',
            's.name as statename',
            'b.budget_range'
        )
        ->where('p.id', $id)
        ->first();

    if (!$project) {
        abort(404);
    }

    $vendors = DB::connection('mysql')
        ->table('vendor_reg')
        ->where('work_type_id', $project->work_type_id)
        ->where('status', 'approved')
        ->when($project->work_subtype_id, function ($query) use ($project) {
            $query->whereRaw(
                "JSON_CONTAINS(work_subtype_id, ?)",
                ['"' . $project->work_subtype_id . '"']
            );
        })
        ->when($project->city_id, function ($query) use ($project) {
            $query->where(function ($q) use ($project) {
                $q->where('city', $project->city_id)
                  ->orWhere('region', $project->region_id)
                  ->orWhere('state', $project->state_id)
                  ->orWhereNull('state');
            });
        })
        ->orderByDesc('experience_years')
        ->orderByDesc('lead_balance')
        ->get();
// dd($vendors);
    return view('web.employers.project_details', compact('project', 'vendors'));
}


public function sendSelectedMail(Request $request)
{
    $request->validate([
        'vendor_ids' => 'required|array',
        'project_id' => 'required'
    ]);

    $project = DB::connection('tenant')
        ->table('projects')
        ->where('id', $request->project_id)
        ->first();

    if (!$project) {
        return back()->with('error', 'Project not found');
    }

    $vendors = DB::connection('mysql')
        ->table('vendor_reg')
        ->whereIn('id', $request->vendor_ids)
        ->get();

    foreach ($vendors as $vendor) {

        $subject = "New Project Opportunity - ".$project->contact_name;

        $messageBody = "
        Hello {$vendor->name},

        You have been invited for a new project on ConstructKaro.

        Project Name: {$project->contact_name}
        Project Code: {$project->code}
        Budget: ₹".number_format($project->budget)."

        Please login to your dashboard and review the project details.

        Also ensure your profile documents are updated.

        Login Here:
        ".url('auth/login/vendor')."

        Regards,
        ConstructKaro Team
        ";

        // Save inside database
        DB::connection('tenant')->table('project_vendor_emails')->insert([
            'project_id' => $project->id,
            'vendor_id' => $vendor->id,
            'vendor_email' => $vendor->email,
            'subject' => $subject,
            'message' => $messageBody,
            'sent_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::connection('mysql')->table('project_vendor_emails')->insert([
            'project_id' => $project->id,
            'vendor_id' => $vendor->id,
            'vendor_email' => $vendor->email,
            'subject' => $subject,
            'message' => $messageBody,
            'sent_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Send Mail
        Mail::raw($messageBody, function ($mail) use ($vendor, $subject) {
            $mail->to($vendor->email)
                 ->subject($subject);
        });
    }

    return back()->with('success', 'Emails sent and saved successfully!');
}
public function pqc($projectId)
{
    $rows = DB::table('vendor_pqc_submissions as vps')
        ->join('vendor_reg as v', 'v.id', '=', 'vps.vendor_id')
        ->where('vps.project_id', $projectId) // Option A
        // ->join('erp_notifications as en', 'en.id','=','vps.notification_id')
        // ->where('en.project_id', $projectId) // Option B
        ->orderByDesc('vps.id')
        ->get([
            'vps.*',
            'v.company_name as vendor_company',
            'v.name as vendor_name',
            'v.mobile as vendor_mobile',
        ]);

    return view('web.employers.pqc_list', compact('rows','projectId'));
}

public function acceptPqc($id)
{
    
     $employer_id   = Session::get('employer_id');
    //  dd($employer_id);
    DB::table('vendor_pqc_submissions')
        ->where('id', $id)
        ->update([
            'accept_status' => 'accepted',
            'accepted_at'   => now(),
            'accepted_by'   => $employer_id, // employer logged in user
            'updated_at'    => now(),
        ]);

    return back()->with('success', 'Vendor accepted successfully.');
}


public function compareVendorReplies($projectId)
{
    $rfq = DB::connection('tenant')->table('rfqs')
        ->where('project_id', $projectId)
        ->orderByDesc('id')
        ->first();
// dd($rfq);
    if (!$rfq) {
        return response()->json([
            'ok' => false,
            'message' => 'RFQ not found'
        ]);
    }

    $rows = DB::connection('tenant')->table('rfq_vendor_invites as rvi')
        // ->join('constructkaro_erp.vendor_reg as v', 'v.id', '=', 'rvi.vendor_id')
        ->where('rvi.rfq_id', $rfq->id)
        ->whereNotNull('rvi.total_quote')
        ->orderBy('rvi.total_quote', 'asc')   // LOW TO HIGH
        ->select(
            'rvi.id',
            'rvi.rfq_id',
            'rvi.vendor_id',
            'rvi.reply_file',
            'rvi.total_quote',
            'rvi.delivery_timeline',
            'rvi.status',
            'rvi.replied_at',
            'rvi.selected_vendor',
            // 'v.company_name',
            // 'v.name',
            // 'v.mobile'
        )
        ->get();
// dd( $rows );
    return response()->json([
        'ok' => true,
        'rfq_id' => $rfq->id,
        'rows' => $rows
    ]);
}

public function selectWinner($id)
{
    // dd($id);
    $selectedRow = DB::connection('tenant')->table('rfq_vendor_invites')->where('project_id', $id)->first();
// dd($selectedRow);
    if (!$selectedRow) {
        return response()->json([
            'ok' => false,
            'message' => 'Vendor row not found'
        ]);
    }

    DB::connection('tenant')->table('rfq_vendor_invites')
        ->where('rfq_id', $selectedRow->rfq_id)
        ->update([
            'selected_vendor' => 0,
            'updated_at' => now()
        ]);

    DB::connection('tenant')->table('rfq_vendor_invites')
        ->where('id', $id)
        ->update([
            'selected_vendor' => 1,
            'updated_at' => now()
        ]);

    return response()->json([
        'ok' => true
    ]);
}
}
