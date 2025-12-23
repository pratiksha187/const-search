<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Suppliers extends Model
{
    // If your table is `products`, this is optional, but explicit is fine:
    protected $table = 'supplier_reg';

//     protected $fillable = [

//     // Basic
//     'shop_name','contact_person','phone','whatsapp','email','shop_address',
//     'city_id','area_id',

//     // Business
//     'primary_type','years_in_business',
//     'gst_number','pan_number','msme_status',

//     // ⬇⬇⬇ ADD THESE ⬇⬇⬇
//     'open_time','close_time',
//     'credit_days',
//     'minimum_order_cost',
//     'delivery_days',
//     'delivery_type',
//     'maximum_distance',

//     // Categories & brands
//     'categories_json','category_notes_json','brands_supplied',

//     // Pricing
//     'price','discount_price','gst_percent',

//     // Service coverage
//     'service_areas',

//     // Docs
//     'gst_certificate_path','pan_card_path','shop_license_path','sample_invoice_path',

//     // Images
//     'images','costing_sheet',

//     // Bank
//     'account_holder','bank_name','account_number','ifsc_code',

//     // Status
//     'status',
// ];

 protected $fillable = [

        // BASIC
        'shop_name',
        'contact_person',
        'phone',
        'whatsapp',
        'email',
        'shop_address',
        'city_id',
        'area_id',

        // BUSINESS
        'primary_type',
        'years_in_business',
        'gst_number',
        'pan_number',
        'msme_status',

        // DELIVERY & CREDIT
        'open_time',
        'close_time',
        'credit_days',
        'delivery_type',
        'delivery_days',
        'minimum_order_cost',
        'maximum_distance',

        // FILES
        'gst_certificate_path',
        'pan_card_path',
        'shop_license_path',
        'sample_invoice_path',
        'costing_sheet',

        // IMAGES
        'images',

        // BANK
        'account_holder',
        'bank_name',
        'account_number',
        'ifsc_code',

        // STATUS
        'status',
    ];
    // Cast JSON columns automatically to arrays
    protected $casts = [
        'categories_json'   => 'array',
        'category_notes_json'=> 'array',
        'service_areas'     => 'array',
        'images'            => 'array',
        'costing_sheet'     => 'array',
        'price'             => 'decimal:2',
        'discount_price'    => 'decimal:2',
        'gst_percent'       => 'decimal:2',
    ];

   
}
