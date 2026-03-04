<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Merchant extends Model
{
    use HasFactory;

    protected $fillable = [
        'merchant_code',
        'merchant_name',
        'owner_name',
        'email',
        'phone',
        'address',
        'city_id',
        'province_id',
        'district_id',
        'village_id',
        'is_active',
    ];

    function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function province()
    {
        return $this->belongsTo(Province::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function district()
    {
        return $this->belongsTo(District::class);
    }

    public function village()
    {
        return $this->belongsTo(Village::class);
    }

    public function merchantUser()
    {
        return $this->hasMany(MerchantUser::class);
    }
}
