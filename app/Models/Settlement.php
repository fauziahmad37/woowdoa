<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Settlement extends Model
{
    use HasFactory;

    protected $fillable = [
        'merchant_id',
        'settlement_code',
        'period_start',
        'period_end',
        'amount',
        'status',
    ];

    function merchant()
    {
        return $this->belongsTo(Merchant::class, 'merchant_id', 'id');
    }

    function transactions()
    {
        return $this->hasMany(Transaction::class, 'settlement_id', 'id');
    }
}
