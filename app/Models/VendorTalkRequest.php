<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VendorTalkRequest extends Model
{
    protected $fillable = [
        'vendor_id',
        'post_id',
        'message',
        'call_time',
        'status'
    ];

}
