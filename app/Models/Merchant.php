<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Merchant extends Model
{
    use HasFactory;

    protected $fillable = [
        'merchant_code',
        'merchant_name',
        'owner_name',
        'email',
        'phone',
        'address',
        'city',
        'province',
        'is_active',
    ];

    function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
