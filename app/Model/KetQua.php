<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class KetQua extends Model
{
    protected $table = "ketqua";

    protected $fillable = [
        'vongdau',
        'doibong_id',
        'status',
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
