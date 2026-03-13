<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ReconcileExport implements FromCollection, WithHeadings
{
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function collection()
    {
        return collect($this->data)->map(function ($row) {
            return [
                $row->transaction_code,
                $row->card_number,
                $row->total_amount,
                $row->paid_amount,
                $row->status,
                $row->paid_at,
                $row->merchant_name,
                $row->student_name,
                $row->ledger_amount,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Kode Transaksi',
            'Nomor Kartu / VA',
            'Total Tagihan',
            'Total Dibayar',
            'Status',
            'Tanggal Bayar',
            'Merchant',
            'Nama Santri',
            'Ledger Amount',
        ];
    }
}