<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentParent extends Model
{
    protected $table = 'parents';

    protected $fillable = [
        'parent_name',
        'phone',
        'email',
        'address',
        'active'
    ];

    // Relasi ke students
    public function students()
    {
        return $this->hasMany(Santri::class, 'parent_id');
    }
}