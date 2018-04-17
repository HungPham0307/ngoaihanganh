<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class KetQua extends Model
{
    protected $table = "ketqua";

    protected $fillable = [
        'capdau_id',
        'tyso',
        'chitiet',
    ];

    public function capDau()
    {
        return $this->belongsTo('App\Model\CapDau','capdau_id','id');
    }
}
