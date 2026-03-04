<?php

namespace App\Http\Controllers\Api;

use App\Services\FirebaseService;

use App\Http\Controllers\Api\BaseApiController;
use App\Services\ImageUploadService;
use App\Http\Controllers\Controller;
use App\Models\Merchant;
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

        return $this->success($merchant, 'User profile retrieved successfully');
    }

    public function profileMerchantOwner(Request $request)
    {
        $user = $request->user();

        $merchant = Merchant::where('id', $user->merchant_id)
            ->first();

        $merchantOwner = $merchant->owners()->first();

        return $this->success($merchantOwner, 'User profile retrieved successfully');
    }

}
