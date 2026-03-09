<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MailLog extends Model
{
    protected $connection = 'tenant';
    protected $table = 'mail_logs';

    protected $fillable = [
        'type','rfq_id','vendor_id','to_email','subject','status','error'
    ];
}