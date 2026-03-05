<?php

namespace App\Http\Controllers\Api;

use App\Services\FirebaseService;

use App\Http\Controllers\Api\BaseApiController;
use App\Services\ImageUploadService;
use App\Http\Controllers\Controller;
use App\Models\Merchant;
use App\Models\MerchantUser;
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
    */
    public function profileMerchant(Request $request)
    {
        $user = $request->user();

        $merchant = Merchant::where('id', $user->merchant_id)
            ->first();

        $merchant->province_name = $merchant->province ? $merchant->province->name : null;
        $merchant->city_name = $merchant->city ? $merchant->city->name : null;
        $merchant->district_name = $merchant->district ? $merchant->district->name : null;
        $merchant->village_name = $merchant->village ? $merchant->village->name : null;

        return $this->success($merchant, 'User profile retrieved successfully');
    }

    /**
     * Edit Profil Merchant by auth
     */
    public function profileMerchantEdit(Request $request)
    {
        $user = $request->user();

        $merchant = Merchant::where('id', $user->merchant_id)
            ->first();

        $merchant->update([
            'merchant_name' => $request->merchant_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'fax' => $request->fax,
            'website' => $request->website,
        ]);

        return $this->success($merchant, 'User profile updated successfully');
    }



    public function profileMerchantOwner(Request $request)
    {
        $user = $request->user();

        $merchantOwner = MerchantUser::where('merchant_id', $user->merchant_id)
            ->where('user_type', 1)
            ->first();

        $merchantOwner->province_name = $merchantOwner->province ? $merchantOwner->province->name : null;
        $merchantOwner->city_name = $merchantOwner->city ? $merchantOwner->city->name : null;
        $merchantOwner->district_name = $merchantOwner->district ? $merchantOwner->district->name : null;
        $merchantOwner->village_name = $merchantOwner->village ? $merchantOwner->village->name : null;

        return $this->success($merchantOwner, 'User profile retrieved successfully');
    }

    public function profileMerchantLeader(Request $request)
    {
        $user = $request->user();

        $merchantLeader = MerchantUser::where('merchant_id', $user->merchant_id)
            ->where('user_type', 2)
            ->first();

        $merchantLeader->province_name = $merchantLeader->province ? $merchantLeader->province->name : null;
        $merchantLeader->city_name = $merchantLeader->city ? $merchantLeader->city->name : null;
        $merchantLeader->district_name = $merchantLeader->district ? $merchantLeader->district->name : null;
        $merchantLeader->village_name = $merchantLeader->village ? $merchantLeader->village->name : null;

        return $this->success($merchantLeader, 'User profile retrieved successfully');
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:6|confirmed',
        ]);

        $user = $request->user();

        if (!\Hash::check($request->current_password, $user->password)) {
            return $this->error('Current password is incorrect', 422);
        }

        $user->password = \Hash::make($request->new_password);
        $user->save();

        return $this->success(null, 'Password updated successfully');
    }

}
