<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ThicknessSize extends Model
{
    protected $table = 'thickness_size';

    protected $fillable = [
        'thickness_size'
    ];

    public $timestamps = true;
}
