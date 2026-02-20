<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employer extends Model
{
    protected $fillable = [
        'name','email','mobile','password',
        'company_name','company_email','company_phone',
        'gst_number','pan_number','company_address','state','city','pincode','website',
        'is_active'
    ];

    protected $hidden = ['password'];
}
