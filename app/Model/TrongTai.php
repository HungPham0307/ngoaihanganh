<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class TrongTai extends Model
{
    protected $table = "trongtai";

    public $timestamps = false;

    protected $fillable = [
        'name',
        'fullname',
        'diachi',
        'ngaysinh',
        'vitri',
        'chitiet',
        'hinhanh',
        'active',
    ];
}
