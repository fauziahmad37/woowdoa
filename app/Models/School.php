<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class School extends Model
{
    use HasFactory;
 


    protected $fillable = [
						'school_name',
						'npsn',
						'address',
						'phone',
						'email',
						'is_active',
						'logo ',
						'no_school',
						'bank',
						'province_id',
						'city_id',
						'district_id',
						'village_id',
						'pic1',
						'pic2',
						'pic3',
    ];

    function teachers()
    {
        return $this->hasMany(Teacher::class, 'school_id', 'id');
    }

    function students()
    {
        return $this->hasMany(Student::class, 'school_id', 'id');
    }

    function users()
    {
        return $this->hasMany(User::class, 'school_id', 'id');
    }
}
