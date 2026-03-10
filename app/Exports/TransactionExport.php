<?php

namespace App\Exports;

use App\Models\Transaction;
use Maatwebsite\Excel\Concerns\FromCollection;

class TransactionExport implements FromCollection
{
    public function collection()
    {
        return Transaction::with(['student','merchant'])
            ->select('transaction_code','total_amount','status','paid_at')
            ->get();
    }
}