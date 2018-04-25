<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ViTri extends Model
{
    protected $table = "vitri";

    protected $fillable = [
        'name',
    ];

    public $timestamps = false;

    public function cauthu()
    {
        return $this->hasMany('App\Model\CauThu', 'vitri_id', 'id');
    }
}
