<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class WaqfTransaction extends Model
{
    protected $fillable = [
        'donor_name',
        'donor_email',
        'donor_phone',
        'amount',
        'transaction_type',
        'purpose',
        'payment_method',
        'payment_status',
        'transaction_code',
        'paid_at',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'paid_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($transaction) {
            if (empty($transaction->transaction_code)) {
                $transaction->transaction_code = 'WQF-' . strtoupper(Str::random(10));
            }
        });
    }
}
