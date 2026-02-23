<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Classes extends Model
{
    protected $table = 'classes';
    use HasFactory;

    protected $fillable = [
        'class_name',
        'class_level',
        'sekolah_id',
    ];
}
