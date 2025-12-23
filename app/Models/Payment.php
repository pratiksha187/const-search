<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'payment_id',
        'order_id',
        'amount',
        'currency',
        'status',
        'user_id',
        'login_id',
        'customer_email',
        'customer_contact',
        'response'
    ];
}
