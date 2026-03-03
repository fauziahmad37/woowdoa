<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class School extends Model
{
    use HasFactory;

    protected $table = 'schools'; // opsional kalau nama tabel sesuai

    protected $fillable = [
        'school_name',
        'address',
        'is_active'
    ];

    // Relasi ke students
    public function students()
    {
        return $this->hasMany(Santri::class, 'school_id');
    }

    // Relasi ke users (kalau user juga punya school_id)
    public function users()
    {
        return $this->hasMany(User::class, 'school_id');
    }
}