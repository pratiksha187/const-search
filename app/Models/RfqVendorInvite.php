<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RfqVendorInvite extends Model
{
    protected $connection = 'tenant';
    protected $table = 'rfq_vendor_invites';

    protected $fillable = [
        'rfq_id','vendor_id','status','invited_at','project_id'
    ];
}