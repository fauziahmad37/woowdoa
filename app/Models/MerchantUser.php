<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Province;
use App\Models\City;
use App\Models\District;
use App\Models\Village;
use App\Models\Merchant;

class MerchantUser extends Model
{
    use HasFactory;

    protected $fillable = [
        'owner_name',
        'email',
        'phone',
        'address',
        'province_id',
        'city_id',
        'district_id',
        'village_id',
        'is_active',
        'merchant_id',
        'user_type',
        'user_id'
    ];

    public function province()
    {
        return $this->belongsTo(Province::class, 'province_id');
    }

    public function city()
    {
        return $this->belongsTo(City::class, 'city_id');
    }

    public function district()
    {
        return $this->belongsTo(District::class, 'district_id');
    }

    public function village()
    {
        return $this->belongsTo(Village::class, 'village_id');
    }

    public function merchant()
    {
        return $this->belongsTo(Merchant::class, 'merchant_id');
    }

    public function level()
{
    return $this->belongsTo(UserLevel::class,'user_type','user_level_id');
}
}
