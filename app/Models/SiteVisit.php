<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteVisit extends Model
{
    protected $table = 'site_visits';

    protected $fillable = [
        'customer_id',
        'vendor_id',
        'visit_date',
        'visit_time',
        'status',
        'payment_status',
        'pdf_path'
    ];
}
