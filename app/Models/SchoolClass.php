<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SchoolClass extends Model
{
    protected $table = 'classes';

    protected $fillable = [
        'class_name',
        'school_id',
        'is_active',
    ];

    // Relasi ke students
    public function students()
    {
        return $this->hasMany(Santri::class, 'class_id');
    }

    // Relasi ke school
    public function school()
    {
        return $this->belongsTo(School::class, 'school_id');
    }
}