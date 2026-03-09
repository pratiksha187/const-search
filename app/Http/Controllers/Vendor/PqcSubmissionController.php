<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\VendorPqcSubmission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class PqcSubmissionController extends Controller
{
    // ✅ CHECK (ONE ROW, no doc_type filter)
    public function check(Request $request)
    {
        $vendorId = Session::get('vendor_id');

        $request->validate([
            'notification_id' => 'required|integer',
        ]);

        $sub = VendorPqcSubmission::where('vendor_id', $vendorId)
            ->where('notification_id', $request->notification_id)
            ->first();

        return response()->json([
            'exists' => (bool) $sub,
            'created_at' => $sub?->created_at?->format('d-m-Y h:i A'),
            'status' => $sub?->status,
            'id' => $sub?->id,

            'project_id' => $sub?->project_id,
            'company_profile_path' => $sub?->company_profile_path,
            'pqc_data' => $sub?->pqc_data,
        ]);
    }

    // ✅ STORE/UPDATE (ONE ROW)
    public function storeOrUpdate(Request $request)
    {
        // dd($request);
        $vendor_id = Session::get('vendor_id');
        if (!$vendor_id) return back()->with('error', 'Vendor not logged in');

        $docType = $request->input('doc_type'); // company | pqc

        $request->validate([
            'notification_id' => ['required', 'integer'],
            'project_id'      => ['nullable'], // ✅ keep nullable if you don't have project_id in notifications
            'doc_type'        => ['required', 'in:company,pqc'],

            'pqc.company_name'=> [$docType === 'pqc' ? 'required' : 'nullable', 'string', 'max:255'],
            'document_file'   => [$docType === 'company' ? 'required' : 'nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'],
        ]);

        // ✅ one row per vendor+notification
        $submission = VendorPqcSubmission::updateOrCreate(
            [
                'vendor_id'       => $vendor_id,
                'notification_id' => $request->notification_id,
            ],
            [
                'project_id' => $request->project_id, // saves if present
            ]
        );

        // ✅ PQC save
        if ($docType === 'pqc') {
            $submission->pqc_data =  $request->input('pqc');
            $submission->status   = 'submitted'; // or 'draft'
        }

        // ✅ Company upload save
        if ($docType === 'company' && $request->hasFile('document_file')) {

            if ($submission->company_profile_path && Storage::disk('public')->exists($submission->company_profile_path)) {
                Storage::disk('public')->delete($submission->company_profile_path);
            }

            $path = $request->file('document_file')->store('vendor/company-profiles', 'public');
            $submission->company_profile_path = $path;

            // ✅ DO NOT set status here (otherwise pqc status gets overwritten)
            // $submission->status = 'submitted';
        }

        $submission->save();

        return back()->with('success', 'Saved successfully.');
    }
}