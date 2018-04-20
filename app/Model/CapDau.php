<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class CapDau extends Model
{
    protected $table = "capdau";

    protected $fillable = [
        'vongdau',
        'doinha_id',
        'doikhach_id',
        'vongdau',
        'date',
        'time',
        'chitiet',
        'doinha_goals',
        'doikhach_goals',
    ];

    public function doinha()
    {
        return $this->belongsTo('App\Model\DoiBong', 'doinha_id', 'id');
    }

    public function doikhach()
    {
        return $this->belongsTo('App\Model\DoiBong', 'doikhach_id', 'id');
    }
}
