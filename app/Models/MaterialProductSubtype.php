<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MaterialProductSubtype extends Model
{
    protected $table = 'material_product_subtype';

    protected $fillable = [
        'material_product_id',
        'material_subproduct'
    ];

    // Relation → Product
    public function product()
    {
        return $this->belongsTo(MaterialProduct::class, 'material_product_id');
    }
}
