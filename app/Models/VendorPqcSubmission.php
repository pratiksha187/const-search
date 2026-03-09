<?php

// app/Models/VendorPqcSubmission.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VendorPqcSubmission extends Model
{
    protected $fillable = [
        'vendor_id',
        'notification_id',
        'doc_type',
        'status','project_id',
        'pqc_data',
        'company_profile_path',
        'pqc_attachment_path',
    ];

    protected $casts = [
        'pqc_data' => 'array',
    ];
}