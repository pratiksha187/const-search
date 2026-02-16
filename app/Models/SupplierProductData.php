<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SupplierProductData extends Model
{
    protected $table = 'supplier_products_data';

    
    protected $fillable = [
    'supp_id',
    'material_category_id',
    'material_product_id',
    'material_product_subtype_id',
    'brand_id',
    'quntity',
    'unit_id',
    'coloursystem',
    'colorname',
    'price',
    'gst_included',
    'gst_percent',
    'delivery_type_id',
    'image',
    'thickness_size',
    'delivery_time'
];

}
