<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class BanThang extends Model
{
    protected $table = "banthang";

    protected $fillable = [
        'cauthu_id',
        'capdau_id',
        'time',
        'chitiet',
    ];
    public $timestamps = false;public $timestamps = false;

    public function cauThu()
    {
        return $this->belongsTo('App\Model\CauThu', 'cauthu_id', 'id');
    }

    public function capDau()
    {
        return $this->belongsTo('App\Model\CauThu', 'capdau_id', 'id');
    }
}
