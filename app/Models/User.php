<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $fillable = [
        'role','name','mobile','email','password'
    ];

    protected $hidden = [
        'password'
    ];
}
