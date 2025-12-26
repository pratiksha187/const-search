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
        return view('web.venderprofile', compact('vendor','workTypes','entity_type','account_type','experience_years','team_size'));
    }


//     public function updateProfile(Request $request)
// {
//     $vendorId = session('user_id');

//     DB::table('vendor_reg')
//         ->where('user_id', $vendorId)
//         ->update([
//             'name' => $request->name,
//             'mobile' => $request->mobile,
//             'email' => $request->email,
//             'business_name' => $request->business_name,
//             'gst_number' => $request->gst_number,
//             'updated_at' => now()
//         ]);

//     return back()->with('success','Profile updated successfully');
// }
  public function getSubtypes($workTypeId)
    {
       
        $subtypes = DB::table('work_subtypes')
                    ->where('work_type_id', $workTypeId)
                    ->get();
                    //  dd($subtypes);
        return response()->json($subtypes);
    }


//   public function updateVendorField(Request $request)
//     {

//         $request->validate([
//             'field' => 'required|string',
//             'value' => 'required|string'
//         ]);
//         $vendor_id = Session::get('vendor_id');
//         DB::table('vendor_reg')
//             ->where('id', $vendor_id)
//             ->update([
//                 $request->field => $request->value,
//                 'updated_at' => now()
//             ]);

//         return redirect()->back()->with('success', 'Profile updated successfully');
//     }
public function updateProfile(Request $request)
{
    // dd($request);
    $vendor_id = session('vendor_id');

    if (!$vendor_id) {
        return back()->with('error', 'Session expired');
    }

    $data = $request->except([
        '_token',
        'pan_card_file',
        'gst_certificate_file',
        'aadhaar_card_file',
        'certificate_of_incorporation_file',
        'pf_documents_file',
        'esic_documents_file',
        'cancelled_cheque_file'
    ]);

    // ✅ FILE UPLOADS
    $fileFields = [
        'pan_card_file',
        'gst_certificate_file',
        'aadhaar_card_file',
        'certificate_of_incorporation_file',
        'pf_documents_file',
        'esic_documents_file',
        'cancelled_cheque_file'
    ];

    foreach ($fileFields as $field) {
        if ($request->hasFile($field)) {
            $data[$field] = $request->file($field)
                ->store("vendor_docs/{$vendor_id}", 'public');
        }
    }

    // ✅ REGION MULTI-SELECT
    if ($request->has('region')) {
        $data['region'] = json_encode($request->region);
    }

    $data['updated_at'] = now();

    DB::table('vendor_reg')
        ->where('id', $vendor_id)
        ->update($data);

    return back()->with('success', 'Profile updated successfully');
}

}
