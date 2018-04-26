<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class MuaGiai extends Model
{
    protected $table = "muagiai";

    protected $fillable = [
        'vongdau',
        'doinha_id',
        'doikhach_id',
        'date',
        'time',
        'sanvandong_id',
        'chitiet',
    ];

    public $timestamps = false;

    public function sanvandong()
    {
        return $this->belongsTo('App\Model\SanVanDong', 'sanvandong_id', 'id');
    }

    public function doinha()
    {
        return $this->belongsTo('App\Model\DoiBong', 'doinha_id', 'id');
    }

    public function doikhach()
    {
        return $this->belongsTo('App\Model\DoiBong', 'doikhach_id', 'id');
    }
}
