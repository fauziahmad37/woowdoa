<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TransactionExport implements FromCollection, WithHeadings
{
    protected $transactions;

    public function __construct($transactions)
    {
        $this->transactions = $transactions;
    }

    public function collection()
    {
        return collect($this->transactions)->map(function ($trx) {
            return [
                'kode_transaksi' => $trx->transaction_code,
                'nama_santri' => $trx->student->student_name ?? '-',
                'merchant' => $trx->merchant->merchant_name ?? '-',
                'total_transaksi' => $trx->total_amount,
                'status' => $trx->status,
                'tanggal_bayar' => $trx->paid_at,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Kode Transaksi',
            'Nama Santri',
            'Merchant',
            'Total Transaksi',
            'Status',
            'Tanggal Bayar'
        ];
    }
}