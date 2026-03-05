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
    ];

    protected $casts = [
        'paid_at' => 'datetime:Y-m-d H:i:s',
        'total_amount' => 'integer',
        'paid_amount' => 'integer',
    ];

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
    
}