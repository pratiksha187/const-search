<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Boq extends Model
{
    protected $connection = 'tenant';
    protected $table = 'boqs';

    protected $fillable = [
        'project_id','uploaded_by','boq_type','original_name','file_path','file_ext','total_items'
    ];

    public function items()
    {
        return $this->hasMany(BoqItem::class, 'boq_id');
    }
}