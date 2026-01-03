<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Suppliers extends Model
{
    protected $table = 'supplier_reg';

    protected $fillable = [
        // 'user_id', // ✅ REQUIRED

        'shop_name',
        'contact_person',
        'mobile',
        'whatsapp',
        'email',
        'shop_address',
        'city_id',
        'state_id',

        'region_id',
        'years_in_business',
        'gst_number',
        'pan_number',
        'msme_status',

        'open_time',
        'close_time',
        'credit_days',
        'delivery_type',
        'delivery_days',
        'minimum_order_cost',
        'maximum_distance',

        'gst_certificate_path',
        'pan_card_path',
        'shop_license_path',
        'sample_invoice_path',
        'costing_sheet_path',

        'images',

        'account_holder',
        'bank_name',
        'account_number',
        'ifsc_code',

        'status',
    ];

    protected $casts = [
        'images' => 'array',
    ];
}
