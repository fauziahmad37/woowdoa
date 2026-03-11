<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WalletMovement extends Model
{
    use HasFactory;

    protected $fillable = [
       'ewallet_id',
       'transaction_id',
       'type',
       'amount',
       'balance_before',
       'balance_after',
       'description'
    ];

    protected $casts = [
        'balance_before' => 'integer',
        'balance_after' => 'integer',
        'amount' => 'integer',
    ];

    public function transaction(){
        $this->belongsTo(Transaction::class, 'transaction_id', 'id');
    }
}