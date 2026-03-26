<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Santri extends Model
{
    use SoftDeletes;
protected $table = 'students';
    protected $fillable = [
        'nis',
        'student_name',
        'gender',
        'address',
        'phone',
        'email',
        'active',
        'saldo',
        'pin',
        'user_id',
        'tahun_ajaran_id',
        'class_id',
        'school_id',
        'password',
        'parent_id',
        'deleted_at',
        'is_delete',
         'va_number'
    ];

    protected $casts = [
        'active' => 'boolean',
    ];

    public function user()
{
    return $this->belongsTo(User::class, 'user_id');
}


    public function school()
{
    return $this->belongsTo(School::class, 'school_id');
}

    public function tahunajaran()
{
    return $this->belongsTo(TahunAjaran::class, 'tahun_ajaran_id');
}

public function schoolClass()
{
    return $this->belongsTo(SchoolClass::class, 'class_id');
}

public function parent()
{
    return $this->belongsTo(Parents::class, 'parent_id');
}
}