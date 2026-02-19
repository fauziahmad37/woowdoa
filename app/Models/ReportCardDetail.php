<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportCardDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'report_card_id',
        'subject_name',
        'final_score',
        'grade'
    ];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];

    public function reportCard()
    {
        return $this->belongsTo(ReportCard::class, 'report_card_id', 'id');
    }
}
