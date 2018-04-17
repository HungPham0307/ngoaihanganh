<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class BangDiem extends Model
{
    protected $table = "bangdiem";

    protected $fillable = [
        'doibong_id',
        'thang',
        'hoa',
        'thua',
        'hieuso',
        'diem',
        'sotran',
        'ban_thang',
        'ban_thua'
    ];

    public function doiBong()
    {
        return $this->belongsTo('App\Model\DoiBong','doibong_id','id');
    }
}
