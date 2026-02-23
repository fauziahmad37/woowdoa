<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class School extends Model
{
    use HasFactory;

    protected $fillable = [
        'school_name',
        'address',
        'phone',
        'email',
        'is_active',
        'logo',
    ];

    function teachers()
    {
        return $this->hasMany(Teacher::class, 'school_id', 'id');
    }
}
