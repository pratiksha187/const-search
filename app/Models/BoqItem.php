<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BoqItem extends Model
{
    protected $connection = 'tenant';
    protected $table = 'boq_items';

    protected $fillable = [
        'boq_id','row_no','item_code','description','unit','qty','rate','amount'
    ];

    public function boq()
    {
        return $this->belongsTo(Boq::class, 'boq_id');
    }
}