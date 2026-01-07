<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
class VenderController extends Controller
{
    public function venderprofile()
    {
        // $states = DB::table('states')->where('is_active',1)->get(); 
        $entity_type = DB::table('entity_type')->get(); 
        $states = DB::table('state')->orderBy('name')->get();
      
        $account_type = DB::table('account_type')->get(); 
        $experience_years =DB::table('experience_years')->get(); 
        $team_size =DB::table('team_size')->get(); 
        $workTypes = DB::table('work_types')->get();
        // dd($workTypes);
        $vendor_id = Session::get('vendor_id');
        // dd($vendor_id);
        $vendor = DB::table('vendor_reg')
            ->where('id', $vendor_id)
            ->first();
        // dd($vendor);
        return view('web.venderprofile', compact('vendor','states','workTypes','entity_type','account_type','experience_years','team_size'));
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

}
