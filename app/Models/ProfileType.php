<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProfileType extends Model
{
    protected $table = 'profiletype';

    protected $fillable = [
        'type',
        'sub_categories_id'
    ];

    public function subcategory()
    {
        return $this->belongsTo(
            MaterialProductSubtype::class,
            'sub_categories_id'
        );
    }
}
