<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ewallet extends Model
{
    use HasFactory;

    protected $fillable = [
       'user_id',
       'wallet_type',
       'balance',
    ];

    protected $casts = [
        'balance' => 'integer',
    ];
}