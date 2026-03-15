<?php

namespace App\Exports;


use App\Models\Card;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CardExport implements FromCollection, WithHeadings
{
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    } 
    public function collection()
    { 
        return collect($this->data)->values()->map(function ($row, $index) {
            return [
								$index + 1, // nomor urut
                $row->nis,
                $row->student->student_name,
                $row->card_number,
                $row->sequence,
                $row->status,
                $row->reason
            ];
        });
    }
 
 
    public function headings(): array
    {
			return [
							'No',
							'NIS',
							'Nama Santri',
							'Nomor Kartu',
							'Terbitan Ke',
							'Status',
							'Alasan Terbit' ];
    }
}