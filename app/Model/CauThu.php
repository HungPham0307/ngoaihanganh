<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class CauThu extends Model
{
    protected $table = "cauthu";

    protected $fillable = [
        'name',
        'fullname',
        'diachi',
        'ngaysinh',
        'soao',
        'vitri',
        'doibong_id',
        'email',
        'chitiet',
        'hinhanh',
        'active',
    ];

    public $timestamps = false;

    public function doiBong()
    {
        return $this->belongsTo('App\Model\DoiBong', 'doibong_id', 'id');
    }
}
