<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

use App\Traits\Auditable;

class Parents extends Authenticatable
{
    use Auditable;
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'parent_name',
        'parent_phone',
        'address',
        'active',
        'user_id',
        'school_id',
        'gender',
        'dead_or_alive',
        'latest_education',
        'occupation',
        'income_range_id',
        'province_id',
        'city_id',
        'district_id',
        'village_id',
        'postal_code',
        'student_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function student()
    {
        return $this->hasMany(Student::class, 'parent_id', 'id');
    }

    public function incomeRange()
    {
        return $this->belongsTo(IncomeRange::class, 'income_range_id', 'id');
    }

    public function province()
    {
        return $this->belongsTo(Province::class, 'province_id', 'id');
    }

    public function city()
    {
        return $this->belongsTo(City::class, 'city_id', 'id');
    }

    public function district()
    {
        return $this->belongsTo(District::class, 'district_id', 'id');
    }

    public function village()
    {
        return $this->belongsTo(Village::class, 'village_id', 'id');
    }
}
