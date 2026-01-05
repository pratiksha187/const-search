<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Standard extends Model
{
    protected $table = 'standard_master';

    protected $fillable = [
        'standard_name'
    ];

    public $timestamps = true;
}
