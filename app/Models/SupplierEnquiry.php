<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SupplierEnquiry extends Model
{
    protected $table = 'supplier_enquiries';

    protected $fillable = [
        'supplier_id',
        'category',
        'quantity',
        'specs',
        'delivery_location',
        'required_by',
        'payment_preference',
        'attachments',
    ];

    protected $casts = [
        'attachments' => 'array',
    ];
}
