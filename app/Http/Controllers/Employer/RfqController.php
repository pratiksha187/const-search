<?php

namespace App\Http\Controllers\Employer;

use App\Http\Controllers\Controller;

use App\Models\Boq;
use App\Models\RfqVendorInvite;
use App\Models\MailLog;
use App\Mail\RfqInviteMail;
use App\Models\Rfq;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;


class RfqController extends Controller
{

public function latest($projectId)
{
    $rfq = Rfq::where('project_id', (int)$projectId)
        ->orderByDesc('id')
        ->first();

    if(!$rfq){
        return response()->json(['ok'=>true, 'exists'=>false]);
    }

    return response()->json([
        'ok' => true,
        'exists' => true,
        'rfq' => [
            'id' => $rfq->id,
            'rfq_no' => $rfq->rfq_no,
            'title' => $rfq->title,
            'bid_deadline' => $rfq->bid_deadline,
            'payment_terms' => $rfq->payment_terms,
            'status' => $rfq->status,
            'boq_id' => $rfq->boq_id ?? null,
            'created_at' => optional($rfq->created_at)->format('d M Y, h:i A'),
        ]
    ]);
}
   
public function create(Request $request)
{
    $employer_id = Session::get('employer_id');

    $validator = Validator::make($request->all(), [
        'project_id'     => ['required','integer'],
        'title'          => ['required','string','max:255'],
        'deadline'       => ['nullable','date'],
        'payment_terms'  => ['nullable','string','max:255'],
    ]);

    if ($validator->fails()) {
        return response()->json([
            'ok'      => false,
            'message' => 'Validation failed',
            'errors'  => $validator->errors(),
        ], 422);
    }

    // ✅ IMPORTANT: pass $employer_id into transaction if you want to use it
    return DB::connection('tenant')->transaction(function () use ($request, $employer_id) {

        // ✅ Get latest BOQ for this project (your BOQ table is bqs via Boq model)
        $latestBoq = Boq::where('project_id', (int)$request->project_id)
            ->orderByDesc('id')
            ->first();

        // ✅ Generate RFQ No like RFQ-6-0001
        $lastId = (int)(Rfq::max('id') ?? 0);
       
        $rfqNo  = 'RFQ-' . (int)$request->project_id . '-' . str_pad($lastId + 1, 4, '0', STR_PAD_LEFT);
        $boq_id=$lastId + 1;
        // dd($boq_id);
        $rfq = Rfq::create([
            'project_id'     => (int)$request->project_id,
            'boq_id'         => $boq_id ,   // ✅ SET BOQ ID
            'rfq_no'         => $rfqNo,
            'title'          => $request->title,
            'bid_deadline'   => $request->deadline,
            'payment_terms'  => $request->payment_terms,
            'status'         => 'Draft',
        ]);

        return response()->json([
            'ok'      => true,
            'rfq_id'  => $rfq->id,
            'rfq_no'  => $rfq->rfq_no,
            'boq_id'  => $rfq->boq_id, // ✅ confirm on UI/debug
            'message' => 'RFQ created successfully'
        ]);
    });
}


public function invite(Request $request)
{
    $validator = Validator::make($request->all(), [
        'rfq_id'    => ['required','integer'],
        'vendor_id' => ['required','integer'],
    ]);

    if ($validator->fails()) {
        return response()->json([
            'ok'      => false,
            'message' => 'Validation failed',
            'errors'  => $validator->errors(),
        ], 422);
    }

    try {
        return DB::connection('tenant')->transaction(function () use ($request) {

            $rfq = Rfq::findOrFail((int)$request->rfq_id);
            
            // ✅ IMPORTANT: use tenant connection for vendor_reg
            $vendor = DB::table('vendor_reg')
                ->where('id', (int)$request->vendor_id)
                ->first();

            if (!$vendor) {
                return response()->json([
                    'ok' => false,
                    'message' => 'Vendor not found'
                ], 404);
            }

            // ✅ Adjust email column name if different
            if (empty($vendor->email)) {
               
                return response()->json([
                    'ok' => false,
                    'message' => 'Vendor email not found. Please update vendor email first.'
                ], 422);
            }

            // ✅ Find BOQ for attachment (prefer rfq->boq_id, else latest by project)
            $boq = null;
            if (!empty($rfq->boq_id)) {
                $boq = Boq::find($rfq->boq_id);
                //  dd($boq);
            }
            if (!$boq) {
                $boq = Boq::where('project_id', $rfq->project_id)->orderByDesc('id')->first();
            }

            // ✅ Save invite (avoid duplicate)
            $invite = RfqVendorInvite::updateOrCreate(
                ['rfq_id' => $rfq->id, 'project_id'=>$rfq->project_id,'vendor_id' => (int)$vendor->id],
                ['status' => 'invited', 'invited_at' => now()]
            );

            // ✅ Mail log
            $log = MailLog::create([
                'type'      => 'rfq_invite',
                'rfq_id'    => $rfq->id,
                'vendor_id' => (int)$vendor->id,
                'to_email'  => $vendor->email,
                'subject'   => 'New RFQ Invite - ' . ($rfq->rfq_no ?? ('RFQ#' . $rfq->id)),
                'status'    => 'queued',
                'error'     => null,
            ]);

            try {
                Mail::to($vendor->email)->send(new RfqInviteMail($rfq, $vendor, $boq));
                $log->update(['status' => 'sent']);
            } catch (\Throwable $e) {
                $log->update(['status' => 'failed', 'error' => $e->getMessage()]);

                // ✅ invite saved + log saved, mail failed
                return response()->json([
                    'ok' => false,
                    'message' => 'Invite saved but email failed: ' . $e->getMessage(),
                ], 500);
            }

            return response()->json([
                'ok'        => true,
                'message'   => 'Vendor invited & email sent',
                'invite_id' => $invite->id,
            ]);
        });

    } catch (\Throwable $e) {
        return response()->json([
            'ok' => false,
            'message' => 'Invite failed: ' . $e->getMessage(),
        ], 500);
    }
}
}