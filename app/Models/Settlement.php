<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Settlement extends Model
{
    use HasFactory;

    protected $fillable = [
        'merchant_id',
        'user_id_owner',
        'settlement_code',
        'period_start',
        'period_end',
        'amount',
        'status',
    ];

    // ubah created_at dan updated_at ke format timestamp Y-m-d H:i:s
    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
        'amount' => 'integer',
    ];

    function merchant()
    {
        return $this->belongsTo(Merchant::class, 'merchant_id', 'id');
    }

    function ewallet()
    {
        return $this->belongsTo(Ewallet::class, 'user_id_owner', 'user_id');
    }


    function transactions()
    {
        return $this->hasMany(Transaction::class, 'settlement_id', 'id');
    }
}
