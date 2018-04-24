<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class KetQua extends Model
{
    protected $table = "ketqua";

    protected $fillable = [
        'sotran',
        'doibong_id',
        'muagiai_id',
        'status',
        'banthang',
        'banthua',
        'date',
        'time',
        'chitiet',
    ];
    public $timestamps = false;

    public function doibong()
    {
        return $this->belongsTo('App\Model\DoiBong', 'doibong_id', 'id');
    }
}
