<?php

namespace App\Http\Controllers\Api;

use App\Services\FirebaseService;

use App\Http\Controllers\Api\BaseApiController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Province;
use App\Models\City;
use App\Models\District;
use App\Models\Village;
use Illuminate\Support\Facades\Storage;

class RegionController extends BaseApiController
{
    /**
     * Display a listing of provinces.
     */
    public function provinces()
    {
        $provinces = Province::all();
        return $this->success($provinces, 'Provinces retrieved successfully');
    }

    /**
     * Display a listing of cities based on province ID.
     */
    public function cities($provinceId)
    {
        $cities = City::where('province_id', $provinceId)->get();
        return $this->success($cities, 'Cities retrieved successfully');
    }

    /**
     * Display a listing of districts based on city ID.
     */
    public function districts($cityId)
    {
        $districts = District::where('regency_id', $cityId)->get();
        return $this->success($districts, 'Districts retrieved successfully');
    }

    /**
     * Display a listing of villages based on district ID.
     */
    public function villages($districtId)
    {
        $villages = Village::where('district_id', $districtId)->get();
        return $this->success($villages, 'Villages retrieved successfully');
    }


}
