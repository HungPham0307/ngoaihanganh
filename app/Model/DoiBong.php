<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class DoiBong extends Model
{
    protected $table = "doibong";

    public $timestamps = false;

    protected $fillable = [
        'name',
        'sanvandong_id',
        'diachi',
        'chitiet',
        'email',
        'hinhanh',
        'ngaythanhlap',
    ];

    public function sanVanDong()
    {
        return $this->belongsTo('App\Model\SanVanDong', 'sanvandong_id', 'id');
    }

    public function huanLuyenVien()
    {
        return $this->hasOne('App\Model\HuanLuyenVien', 'huanluyenvien_id', 'id');
    }

    public function cauThu()
    {
        return $this->hasMany('App\Model\CauThu', 'doibong_id', 'id');
    }
}
