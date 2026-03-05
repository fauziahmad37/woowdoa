<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentParent extends Model
{
    protected $table = 'parents';

    protected $fillable = [
        'parent_name',
        'parent_phone',
        'address',
        'user_id',
        'address',
         'deleted_at',
        'is_delete',
        'school_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }


    
    public function school()
    {
        return $this->belongsTo(School::class, 'school_id');
    }
}