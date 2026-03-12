<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CardLossReport extends Model
{ 
    protected $fillable = [
        'card_id',
        'report_date',
        'description',
        'reported_by',
        'approved_by',
        'status'
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
