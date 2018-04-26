<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class HuanLuyenVien extends Model
{
    protected $table = "huanluyenvien";

    protected $fillable = [
        'name',
        'fullname',
        'doibong_id',
        'diachi',
        'ngaysinh',
        'chitiet',
    ];

    public $timestamps = false;

    public function doiBong()
    {
        return $this->belongsTo('App\Model\DoiBong', 'doibong_id', 'id');
    }
}
