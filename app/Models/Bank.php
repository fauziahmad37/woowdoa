<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
    use HasFactory;


    protected $fillable = [
        'nama'
    ];

    public function merchants()
    {
        return $this->hasOne(Merchant::class);
    }

}
