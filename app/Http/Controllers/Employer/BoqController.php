<?php

namespace App\Http\Controllers\Employer;

use App\Http\Controllers\Controller;
use App\Imports\BoqItemsImport;
use App\Models\Boq;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;


class BoqController extends Controller
{

public function latest($projectId)
{
    $boq = Boq::where('project_id', (int)$projectId)
        ->orderByDesc('id')
        ->first();

    if(!$boq){
        return response()->json(['ok'=>true, 'exists'=>false]);
    }

    return response()->json([
        'ok' => true,
        'exists' => true,
        'boq' => [
            'id' => $boq->id,
            'boq_type' => $boq->boq_type,
            'original_name' => $boq->original_name,
            'file_path' => $boq->file_path,
            'file_url' => Storage::disk('public')->url($boq->file_path),
            'total_items' => $boq->total_items,
            'created_at' => optional($boq->created_at)->format('d M Y, h:i A'),
        ]
    ]);
}
    public function upload(Request $request)
    {
        $employer_id = Session::get('employer_id');

        if (!$employer_id) {
            return response()->json([
                'ok' => false,
                'message' => 'Employer session missing. Please login again.'
            ], 401);
        }

        // ✅ JSON validation (no redirect) + CSV mime support
        $validator = Validator::make($request->all(), [
            'project_id' => ['required', 'integer'],
            'boq_type'   => ['nullable', 'string', 'max:100'],
            'boq_file'   => [
                'required',
                'file',
                'max:10240',
                // extensions
                // 'mimes:xlsx,xls,csv',
                // mime types (CSV varies)
                // 'mimetypes:text/plain,text/csv,application/csv,application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
            ],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'ok' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
            return DB::connection('tenant')->transaction(function () use ($request, $employer_id) {

                $file = $request->file('boq_file');
                $ext  = strtolower($file->getClientOriginalExtension());

                // ✅ extra safeguard by extension
                if (!in_array($ext, ['csv', 'xls', 'xlsx'])) {
                    return response()->json([
                        'ok' => false,
                        'message' => 'Only csv/xls/xlsx files allowed'
                    ], 422);
                }

                // store in public disk
                $path = $file->store('boq_uploads', 'public');

                // create boq header (tenant DB due to model connection)
                $boq = Boq::create([
                    'project_id'     => (int)$request->project_id,
                    'uploaded_by'    => $employer_id,
                    'boq_type'       => $request->boq_type,
                    'original_name'  => $file->getClientOriginalName(),
                    'file_path'      => $path,
                    'file_ext'       => $ext,
                    'total_items'    => 0,
                ]);

                // import items
                $import = new BoqItemsImport($boq->id);
                Excel::import($import, $file);

                $boq->update(['total_items' => $import->inserted]);

                return response()->json([
                    'ok'          => true,
                    'boq_id'      => $boq->id,
                    'total_items' => $boq->total_items,
                    'file_url'    => Storage::disk('public')->url($boq->file_path),
                ]);
            });

        } catch (\Throwable $e) {
            return response()->json([
                'ok' => false,
                'message' => 'BOQ upload/import failed: ' . $e->getMessage(),
            ], 500);
        }
    }
}