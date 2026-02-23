<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TahunAjaran extends Model
{
    protected $table = 'tahun_ajaran';
    use HasFactory;

    protected $fillable = [
        'tahun_ajaran',
        'semester',
        'start_date',
        'end_date',
        'is_active',
    ];
}
