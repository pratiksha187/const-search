<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployerUser extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'role',
        'user_type',
        'is_paid'
    ];
}