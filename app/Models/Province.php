<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    protected $table = 'provinces';
    protected $primaryKey = 'id';
    public $incrementing = false; // karena id CHAR
    protected $keyType = 'string';

    public function cities()
    {
        return $this->hasMany(City::class, 'province_id', 'id');
    }
}
