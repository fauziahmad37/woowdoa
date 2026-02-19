<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportCard extends Model
{
    use HasFactory;

    protected $fillable = [
       'student_id',
       'tahun_ajaran_id',
       'total_score',
       'rank',
    ];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];

    public function cardReportDetail()
    {
        return $this->hasMany(ReportCardDetail::class, 'report_card_id', 'id');
    }
}
