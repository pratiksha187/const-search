<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

use App\Helpers\ProfileCompletionHelper;
class VenderController extends Controller
{
    public function venderprofile()
    {
        $vendor_id = Session::get('vendor_id');
        
        $vendor = DB::table('vendor_reg')
                    ->where('id', $vendor_id)
                    ->first();
        $profilePercent = ProfileCompletionHelper::vendor($vendor);

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
        return view('web.venderprofile', compact('vendor','vendor_id','profilePercent','notifications','notificationCount','states','workTypes','entity_type','account_type','experience_years','team_size'));
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
dd($vendor_id);
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
            'company_logo' => 'nullable|max:20480',
            // Files
            'pan_card_file'                     => 'nullable|max:20480',
            'gst_certificate_file'              => 'nullable|max:20480',
            'aadhaar_card_file'                 => 'nullable|max:20480',
            'certificate_of_incorporation_file' => 'nullable|max:20480',
            'pf_documents_file'                 => 'nullable|max:20480',
            'esic_documents_file'               => 'nullable|max:20480',
            'cancelled_cheque_file'             => 'nullable|max:20480',
            'msme_file'                          => 'nullable|max:20480',
            'work_completion_certificates_file1' => 'nullable|max:20480',
            'work_completion_certificates_file2' => 'nullable|max:20480',
            'work_completion_certificates_file3' => 'nullable|max:20480',

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
            'msme_file',
            'company_logo',
            'work_completion_certificates_file1',
            'work_completion_certificates_file2',
            'work_completion_certificates_file3',

        ]);

        /* ================= WORK SUBTYPE (CHECKBOX ARRAY) ================= */
        if ($request->has('work_subtype_id')) {
            $data['work_subtype_id'] = json_encode($request->work_subtype_id);
        }


        /* ================= COMPANY LOGO ================= */
        if ($request->hasFile('company_logo')) {

            // delete old logo if exists
            $oldLogo = DB::table('vendor_reg')
                ->where('id', $vendor_id)
                ->value('company_logo');

            if ($oldLogo && Storage::disk('public')->exists($oldLogo)) {
                Storage::disk('public')->delete($oldLogo);
            }

            $data['company_logo'] = $request->file('company_logo')
                ->store("vendor_logos/{$vendor_id}", 'public');
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

        /* ================= WORK COMPLETION PHOTOS ================= */
        $workImages = [
            'work_completion_certificates_file1',
            'work_completion_certificates_file2',
            'work_completion_certificates_file3',
        ];

        foreach ($workImages as $field) {
            if ($request->hasFile($field)) {

                // delete old image if exists
                $oldFile = DB::table('vendor_reg')
                    ->where('id', $vendor_id)
                    ->value($field);

                if ($oldFile && Storage::disk('public')->exists($oldFile)) {
                    Storage::disk('public')->delete($oldFile);
                }

                $data[$field] = $request->file($field)
                    ->store("vendor_work_photos/{$vendor_id}", 'public');
            }
        }


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
        $vendorId = session('vendor_id');
    
        $custId   = $request->customer_id;
        //  dd( $custId );
        if (!$vendorId) {
            return response()->json([
                'balance' => 0,
                'already_exists' => false
            ]);
        }

        /* ===============================
        1️⃣ CHECK ALREADY ENQUIRED
        ================================ */
        $already = DB::table('vendor_interests')
            ->where('vendor_id', $vendorId)
            ->where('customer_id', $custId)
            ->exists();

        if ($already) {

            $customer = DB::table('users')->where('id', $custId)->first();

            return response()->json([
                'already_exists'  => true,
                'balance'         => null,
                'customer_mobile' => $customer->mobile ?? '',
                'customer_email'  => $customer->email ?? ''
            ]);
        }

        /* ===============================
        2️⃣ CHECK LEAD BALANCE
        ================================ */
        $vendor = DB::table('vendor_reg')
            ->where('id', $vendorId)
            ->first();

        if (!$vendor) {
            return response()->json([
                'balance' => 0,
                'already_exists' => false
            ]);
        }

        return response()->json([
            'already_exists' => false,
            'balance' => $vendor->lead_balance
        ]);
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

    // vendorleadhistory
    public function vendorleadhistory(Request $request){
        $vendor_id  = session('vendor_id');
        $vendor = DB::table('vendor_reg')->where('id', $vendor_id)->first();
        // $get_lead_data = DB::table('vendor_interests')
        //                 ->where('vendor_id', $vendorId)->get();
        // // dd($get_lead_data );
        // return view('web.vendorleadhistory');
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
        $search = $request->search;

        $leads = DB::table('vendor_interests as vi')
                    ->leftJoin('users as u', 'u.id', '=', 'vi.customer_id')
                    ->where('vi.vendor_id', $vendor_id)

                    ->when($search, function ($q) use ($search) {
                        $q->where(function ($sub) use ($search) {
                            $sub->where('u.name', 'like', "%{$search}%")
                                ->orWhere('vi.action_status', 'like', "%{$search}%");
                        });
                    })

                    ->select([
                        'vi.id',
                        'vi.customer_id',
                        'vi.vendor_id',
                        'vi.vendor_name',
                        'vi.action_status',
                        'vi.is_read',
                        'u.name as customer_name',
                        'u.email as customer_email',
                        'u.mobile as customer_mobile',
                    ])

                    ->orderBy('vi.created_at', 'desc')
                    ->paginate(10)
                    ->withQueryString();


    return view('web.vendorleadhistory', compact('leads', 'search','vendor_id','vendor','notifications','notificationCount'));
        
    }

    public function vendorsubscription(){
        $vendor_id  = session('vendor_id');
        $vendor = DB::table('vendor_reg')->where('id', $vendor_id)->first();
       
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

        $freeLeadPlatforms = DB::table('free_lead_requests')
                            ->where('vendor_id', $vendor_id)
                            ->whereIn('platform', ['instagram','facebook'])
                            ->pluck('platform')
                            ->toArray();
        //    dd( $notifications );     
        $notificationCount = $notifications->count(); 
         return view('web.vendorsubscription',compact('vendor_id','vendor','notifications','notificationCount','freeLeadPlatforms'));
    }

    public function storerate(Request $request)
    {
        $request->validate([
            'vendor_id' => 'required|integer',
            'rating'    => 'required|integer|min:1|max:5',
            'comment'   => 'nullable|string'
        ]);

        DB::table('vendor_ratings')->insert([
            'vendor_id'   => $request->vendor_id,
            'rating'      => $request->rating,
            'comment'     => $request->comment,
            'created_at'  => now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Rating submitted successfully'
        ]);
    }
}
