<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rfq extends Model
{
    protected $connection = 'tenant';
    protected $table = 'rfqs';

    protected $fillable = [
        'project_id',
        'rfq_no','boq_id',
        'title',
        'bid_deadline',
        'payment_terms',
        'status',
    ];
}