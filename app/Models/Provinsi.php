<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Provinsi extends Model
{
    protected $table = 'provinsi';
    protected $primaryKey = 'id';
    public $incrementing = false; // karena id CHAR
    protected $keyType = 'string';

    public function kota()
    {
        return $this->hasMany(Kota::class, 'province_id', 'id');
    }
}
