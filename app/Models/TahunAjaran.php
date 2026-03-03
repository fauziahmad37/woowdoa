<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TahunAjaran extends Model
{
    protected $table = 'tahun_ajaran';

    protected $fillable = [
        'tahun_ajaran',
        'is_active',
    ];

    // Relasi ke students
    public function tahunajarans()
    {
        return $this->hasMany(Santri::class, 'tahun_ajaran_id');
    }
}