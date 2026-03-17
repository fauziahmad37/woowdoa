<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'merchant_id',
        'transaction_code',
        'student_id',
        'total_amount',
        'paid_amount',
        'paid_at',
        'status',
        'payment_type_id',
        'card_number',
        'settlement_id',
        'trx_id_bank',
    ];

    protected $casts = [
        'paid_at' => 'datetime',
        'total_amount' => 'integer',
        'paid_amount' => 'integer',
    ];

    public function getPaidAtAttribute($value)
    {
        if (!$value) {
            return "";
        }

        return \Carbon\Carbon::parse($value)->format('Y-m-d H:i:s');
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function merchant()
    {
        return $this->belongsTo(Merchant::class);
    }

    public function details()
    {
        return $this->hasMany(TransactionDetail::class, 'transaction_id');
    }

    public function wallet_movements()
    {
        return $this->hasMany(WalletMovement::class, 'transaction_id');
    }

    public function settlement()
    {
        return $this->belongsTo(Settlement::class, 'settlement_id', 'id');
    }
}
