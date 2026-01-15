<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Whight extends Model
{
    protected $table = 'whight';

    protected $fillable = [
        'name'
    ];

    public $timestamps = true;
}
