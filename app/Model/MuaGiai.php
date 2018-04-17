<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class MuaGiai extends Model
{
    protected $table = "muagiai";

    protected $fillable = [
        'vongdau',
        'doinha',
        'doikhach',
        'date',
        'time',
        'sanvandong_id',
        'chitiet',
    ];

    public function sanvandong()
    {
        return $this->belongsTo('App\Model\SanVanDong','sanvandong_id','id');
    }
}
