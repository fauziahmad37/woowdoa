<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionDetail extends Model
{
     protected $table = 'transaction_details';
    use HasFactory;

    protected $fillable = [
        'transaction_id',
        'description',
        'reference',
        'product_type',
        'product_name',
        'quantity',
        'price',
        'sub_total',
    ];

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }


}
