<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class CapDau extends Model
{
    protected $table = "capdau";

    protected $fillable = [
        'sanvandong_id',
        'ngaythidau',
        'doi1',
        'doi2',
        'vongdau_id',
        'doibong_id',
    ];

    public function sanVanDong()
    {
        return $this->belongsTo('App\Model\SanVanDong','sanvandong_id','id');
    }

    public function vongDau()
    {
        return $this->belongsTo('App\Model\VongDau','vongdau_id','id');
    }

    public function doiBong()
    {
        return $this->belongsTo('App\Model\DoiBong','vongdau_id','id');
    }

    public function banThang()
    {
        return $this->hasMany('App\Model\BanThang','capdau_id','id');
    }

    public function ketQua()
    {
        return $this->hasOne('App\Model\KetQua','capdau_id','id');
    }
}
