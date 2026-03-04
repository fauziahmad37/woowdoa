<?php

namespace App\Http\Controllers\Api;

use App\Services\FirebaseService;

use App\Http\Controllers\Api\BaseApiController;
use App\Services\ImageUploadService;
use App\Http\Controllers\Controller;
use App\Models\Merchant;
use App\Models\MerchantUser;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use App\Models\User;

class UserController extends BaseApiController
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 10);

        $users = User::query()
            ->when($request->search, function ($query) use ($request) {
                $query->whereRaw('LOWER(name) like ?', ['%' . strtolower($request->search) . '%']);
            })
            ->latest()
            ->paginate($perPage);

        // transform image_url jadi full URL
        $users->getCollection()->transform(function ($item) {
            if ($item->image_url) {
                $item->image_url = asset($item->image_url);
            }
            return $item;
        });

        return $this->successPaginate($users, 'List of users retrieved successfully');
    }

    /**
     * Get Profile by auth
     * @return \Illuminate\Http\JsonResponse
    */
    public function profileMerchant(Request $request)
    {
        $user = $request->user();

        $merchant = Merchant::where('id', $user->merchant_id)
            ->first();

        return $this->success($merchant, 'User profile retrieved successfully');
    }

    public function profileMerchantOwner(Request $request)
    {
        $user = $request->user();

        $merchant = Merchant::where('id', $user->merchant_id)
            ->first();

        $merchantOwner = MerchantUser::where('merchant_id', $merchant->id)
            ->where('user_type', 1)
            ->join('provinces', 'merchant_users.province_id', '=', 'provinces.id')
            ->join('cities', 'merchant_users.city_id', '=', 'cities.id')
            ->join('districts', 'merchant_users.district_id', '=', 'districts.id')
            ->join('villages', 'merchant_users.village_id', '=', 'villages.id')
            ->select('merchant_users.*', 'provinces.name as province_name', 'cities.name as city_name', 'districts.name as district_name', 'villages.name as village_name')
            ->first();

        return $this->success($merchantOwner, 'User profile retrieved successfully');
    }

    public function profileMerchantLeader(Request $request)
    {
        $user = $request->user();

        $merchant = Merchant::where('id', $user->merchant_id)
            ->first();

        $merchantLeader = MerchantUser::where('merchant_id', $merchant->id)
            ->where('user_type', 2)
            ->join('provinces', 'merchant_users.province_id', '=', 'provinces.id')
            ->join('cities', 'merchant_users.city_id', '=', 'cities.id')
            ->join('districts', 'merchant_users.district_id', '=', 'districts.id')
            ->join('villages', 'merchant_users.village_id', '=', 'villages.id')
            ->select('merchant_users.*', 'provinces.name as province_name', 'cities.name as city_name', 'districts.name as district_name', 'villages.name as village_name')
            ->first();

        return $this->success($merchantLeader, 'User profile retrieved successfully');
    }

    public function resetPassword(Request $request)
    {
        $user = $request->user();

        $request->validate([
            'current_password' => ['required', 'current_password'],
            'new_password' => [
                'required',
                'confirmed',
                Password::min(6)
            ],
        ]);

        $user->update([
            'password' => Hash::make($request->new_password),
        ]);

        return $this->success(null, 'Password updated successfully');
    }
}
