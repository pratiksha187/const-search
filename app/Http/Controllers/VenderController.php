<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
class VenderController extends Controller
{
    public function venderprofile()
    {
        $vendor_id = Session::get('vendor_id');
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
        // $states = DB::table('states')->where('is_active',1)->get(); 
        $entity_type = DB::table('entity_type')->get(); 
        $states = DB::table('state')->orderBy('name')->get();
      
        $account_type = DB::table('account_type')->get(); 
        $experience_years =DB::table('experience_years')->get(); 
        $team_size =DB::table('team_size')->get(); 
        $workTypes = DB::table('work_types')->get();
        // dd($workTypes);
        // dd($vendor_id);
        $vendor = DB::table('vendor_reg')
            ->where('id', $vendor_id)
            ->first();
        // dd($vendor);
        return view('web.venderprofile', compact('vendor','vendor_id','notifications','notificationCount','states','workTypes','entity_type','account_type','experience_years','team_size'));
    }

    public function getSubtypes($workTypeId)
    {
       
        $subtypes = DB::table('work_subtypes')
                    ->where('work_type_id', $workTypeId)
                    ->get();
                    //  dd($subtypes);
        return response()->json($subtypes);
    }


    public function updateProfile(Request $request)
    {
        $vendor_id = session('vendor_id');

        if (!$vendor_id) {
            return back()->with('error', 'Session expired. Please login again.');
        }

        /* ================= VALIDATION ================= */
        $request->validate([
            'mobile'        => 'nullable|string|max:15',
            'email'         => 'nullable|email',
            'business_name' => 'nullable|string|max:255',

            'gst_number'    => 'nullable|string|size:15',
            'pan_number'    => 'nullable|string|size:10',

            'work_type_id'  => 'nullable|integer',
            'work_subtype_id' => 'nullable|array',

            'state'  => 'nullable|integer',
            'region' => 'nullable|integer',
            'city'   => 'nullable|integer',

            // Files
            'pan_card_file'                     => 'nullable|file|mimes:pdf|max:20480',
            'gst_certificate_file'              => 'nullable|file|mimes:pdf|max:20480',
            'aadhaar_card_file'                 => 'nullable|file|mimes:pdf|max:20480',
            'certificate_of_incorporation_file' => 'nullable|file|mimes:pdf|max:20480',
            'pf_documents_file'                 => 'nullable|file|mimes:pdf|max:20480',
            'esic_documents_file'               => 'nullable|file|mimes:pdf|max:20480',
            'cancelled_cheque_file'             => 'nullable|file|mimes:pdf|max:20480',
            'msme_file'                          => 'nullable|file|mimes:pdf|max:20480',
        ]);

        /* ================= BASE DATA ================= */
        $data = $request->except([
            '_token',
            'work_subtype_id',
            'pan_card_file',
            'gst_certificate_file',
            'aadhaar_card_file',
            'certificate_of_incorporation_file',
            'pf_documents_file',
            'esic_documents_file',
            'cancelled_cheque_file',
            'msme_file'
        ]);

        /* ================= WORK SUBTYPE (CHECKBOX ARRAY) ================= */
        if ($request->has('work_subtype_id')) {
            $data['work_subtype_id'] = json_encode($request->work_subtype_id);
        }

        /* ================= FILE UPLOAD HANDLER ================= */
        $fileFields = [
            'pan_card_file',
            'gst_certificate_file',
            'aadhaar_card_file',
            'certificate_of_incorporation_file',
            'pf_documents_file',
            'esic_documents_file',
            'cancelled_cheque_file',
            'msme_file'
        ];

        foreach ($fileFields as $field) {
            if ($request->hasFile($field)) {

                // delete old file if exists
                $oldFile = DB::table('vendor_reg')
                    ->where('id', $vendor_id)
                    ->value($field);

                if ($oldFile && Storage::disk('public')->exists($oldFile)) {
                    Storage::disk('public')->delete($oldFile);
                }

                $data[$field] = $request->file($field)
                    ->store("vendor_docs/{$vendor_id}", 'public');
            }
        }

        /* ================= TIMESTAMP ================= */
        $data['updated_at'] = now();

        /* ================= UPDATE ================= */
        DB::table('vendor_reg')
            ->where('id', $vendor_id)
            ->update($data);

        return back()->with('success', 'Profile updated successfully ✅');
    }

    public function vendorprofileid($id)
    {
        $customer_id = Session::get('customer_id');
        $cust_data = DB::table('users')->where('id',$customer_id)->first();
        // 1️⃣ Fetch vendor basic data
        $vendor_data_byid = DB::table('vendor_reg as v')
            ->leftJoin('work_types as wt', 'wt.id', '=', 'v.work_type_id')
            ->leftJoin('team_size as ts', 'ts.id', '=', 'v.team_size')
            ->leftJoin('state as s', 's.id', '=', 'v.state')
            ->leftJoin('region as r', 'r.id', '=', 'v.region')
            ->leftJoin('city as c', 'c.id', '=', 'v.city')
            ->select(
                'v.*',

                // work
                'wt.work_type as work_typename',
                'ts.team_size as team_size_data',

                // location
                's.name as statename',
                'r.name as regionname',
                'c.name as cityname'
            )
            ->where('v.id', $id)
            ->first();

        // 2️⃣ Safety check
        if (!$vendor_data_byid) {
            abort(404, 'Vendor not found');
        }

        // 3️⃣ Decode work subtype IDs & fetch names
        $workSubtypes = [];

        if (!empty($vendor_data_byid->work_subtype_id)) {
            $subtypeIds = json_decode($vendor_data_byid->work_subtype_id, true);

            if (is_array($subtypeIds) && count($subtypeIds)) {
                $workSubtypes = DB::table('work_subtypes')
                    ->whereIn('id', $subtypeIds)
                    ->pluck('work_subtype')
                    ->toArray();
            }
        }

        $postIds = DB::table('posts')
                    ->where('user_id', $customer_id)
                    ->pluck('id');
        $notifications = DB::table('vendor_interests as vi')
                // ->join('vendor_reg as v', 'v.id', '=', 'vi.vendor_id')
                ->whereIn('vi.customer_id', $postIds)
            
                ->get();
        $notificationCount = $notifications->count();

        // 4️⃣ Send data to view
        return view('web.vendor-profile', compact('vendor_data_byid', 'workSubtypes','cust_data','notificationCount','notifications'));
    }


    public function checkLeadBalance(Request $request)
    {
       
        $vendorId  = session('vendor_id');
       
        // Assuming you have a 'customers' table with 'lead_balance' column
        $vendor_lead_check = DB::table('vendor_reg')
                    ->where('id', $vendorId)->first();

        if (!$vendor_lead_check) {
            return response()->json(['balance' => 0]);
        }

        return response()->json(['balance' => $vendor_lead_check->lead_balance]);
    }


    public function claimFreeLead(Request $request)
    {
       
        $vendorId  = session('vendor_id');
        // dd($vendorId);
        $request->validate([
            'platform' => 'required|in:instagram,facebook'
        ]);

        // Get vendor record
        $vendor = DB::table('vendor_reg')->where('id', $vendorId)->first();
        // dd($vendor);
        if (!$vendor) {
            return response()->json([
                'status' => false,
                'message' => 'Vendor not found'
            ]);
        }

        // Increment the lead balance by 1
        DB::table('vendor_reg')
            ->where('id', $vendorId)
            ->increment('lead_balance', 1);

        return response()->json([
            'status' => true,
            'message' => "1 free lead added for {$request->platform}"
        ]);
    }


}
