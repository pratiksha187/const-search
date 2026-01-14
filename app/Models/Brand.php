<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    protected $table = 'brands';

    protected $fillable = [
        'name',
        'logo',
        'material_product_id'
    ];

    public function product()
    {
        return $this->belongsTo(MaterialProduct::class, 'material_product_id');
    }
}
