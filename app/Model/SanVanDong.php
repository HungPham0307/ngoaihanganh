<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class SanVanDong extends Model
{
    protected $table = "sanvandong";

    protected $fillable = [
        'ten',
        'bat_dau',
        'ket_thuc',
        'chitiet',
        'hinhanh',
    ];

    public function doiBong()
    {
    	return $this->hasOne('App\Model\DoiBong','sanvandong_id','id');
    }
}
