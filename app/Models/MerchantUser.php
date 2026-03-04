<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        'user_type'
    ];

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

    public function merchant()
    {
        return $this->belongsTo(Merchant::class);
    }
}
