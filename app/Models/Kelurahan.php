<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kelurahan extends Model
{
    protected $table = 'kelurahan';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    public function kecamatan()
    {
        return $this->belongsTo(Kecamatan::class, 'district_id', 'id');
    }
}


