<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
   
    protected $fillable = [
        'payment_id',
        'order_id',
        'base_amount',
        'gst_amount',
        'amount',
        'currency',
        'status',
        'customer_email',
        'customer_contact',
        'response',
        'plan',
        'invoice_no',
        'invoice_path',
        'payment_method',
        'invoice_date',
        'user_id',
        'login_id',
        'flag',
        'credits_added',
    ];
}
