<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MaterialProduct extends Model
{
    protected $table = 'material_product';

    protected $fillable = [
        'material_id',
        'product_name'
    ];

    // Relation
    public function category()
    {
        return $this->belongsTo(MaterialCategory::class, 'material_id');
    }
}
