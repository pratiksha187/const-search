<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    // protected $fillable = [
    //     'payment_id',
    //     'order_id',
    //     'amount',
    //     'currency',
    //     'status',
    //     'user_id',
    //     'login_id',
    //     'customer_email',
    //     'customer_contact',
    //     'response'
    // ];
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
        'user_id',
        'login_id',
        'flag',
        'credits_added',
        'plan',
        'invoice_no',
        'invoice_path',
        'payment_method',
        'invoice_date',
    ];
}
