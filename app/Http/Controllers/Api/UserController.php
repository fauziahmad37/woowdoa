<?php

namespace App\Http\Controllers\Api;

use App\Services\FirebaseService;

use App\Http\Controllers\Api\BaseApiController;
use App\Services\ImageUploadService;
use App\Http\Controllers\Controller;
use App\Models\Merchant;
use App\Models\Parents;
use App\Models\Student;
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

        // jika user level selain merchant owner / 2 maka tidak bisa edit profil merchant
        if ($user->user_level_id != 2) {
            return $this->error('Unauthorized', 403);
        }

        $merchant = Merchant::where('id', $user->merchant_id)
            ->first();

        $merchant->update([
            'merchant_name' => $request->merchant_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'fax' => $request->fax,
            'website' => $request->website,
            'province_id' => $request->province_id,
            'city_id' => $request->city_id,
            'district_id' => $request->district_id,
            'village_id' => $request->village_id,
        ]);

        return $this->success($merchant, 'User profile updated successfully');
    }

    /**
     * Get Profile Merchant Owner by auth
     */
    public function profileMerchantOwner(Request $request)
    {
        $user = $request->user();

        // jika user level selain merchant owner / 1 maka tidak bisa akses profil merchant owner
        if ($user->user_level_id != 2) {
            return $this->error('User login anda tidak diizinkan', 403);
        }

        $merchantOwner = MerchantUser::where('merchant_id', $user->merchant_id)
            ->where('user_type', 2)
            ->first();

        $merchantOwner->province_name = $merchantOwner->province ? $merchantOwner->province->name : null;
        $merchantOwner->city_name = $merchantOwner->city ? $merchantOwner->city->name : null;
        $merchantOwner->district_name = $merchantOwner->district ? $merchantOwner->district->name : null;
        $merchantOwner->village_name = $merchantOwner->village ? $merchantOwner->village->name : null;

        return $this->success($merchantOwner, 'User profile retrieved successfully');
    }

    /**
     * Edit Profil Merchant Owner by auth
     */
    public function profileMerchantOwnerEdit(Request $request)
    {
        $user = $request->user();
        // jika user level selain merchant owner / 1 maka tidak bisa edit profil merchant owner
        if ($user->user_level_id != 2) {
            return $this->error('Unauthorized', 403);
        }
        $merchantOwner = MerchantUser::where('merchant_id', $user->merchant_id)
            ->where('user_type', 1)
            ->first();
        $merchantOwner->update([
            'owner_name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'province_id' => $request->province_id,
            'city_id' => $request->city_id,
            'district_id' => $request->district_id,
            'village_id' => $request->village_id,
        ]);

        return $this->success($merchantOwner, 'User profile updated successfully');
    }

    /**
     * Get Profile Merchant Cachier by auth
     */
    public function profileMerchantCachier(Request $request)
    {
        $user = $request->user();

        $merchantCachier = MerchantUser::where('merchant_id', $user->merchant_id)
            ->where('user_type', 3)
            ->first();
        $merchantCachier->province_name = $merchantCachier->province ? $merchantCachier->province->name : null;
        $merchantCachier->city_name = $merchantCachier->city ? $merchantCachier->city->name : null;
        $merchantCachier->district_name = $merchantCachier->district ? $merchantCachier->district->name : null;
        $merchantCachier->village_name = $merchantCachier->village ? $merchantCachier->village->name : null;
        return $this->success($merchantCachier, 'User profile retrieved successfully');
    }

    /**
     * Edit Profil Merchant Cashier by auth
     */
    public function profileMerchantCashierEdit(Request $request)
    {
        $user = $request->user();

        // jika user level selain merchant cashier / 3 maka tidak bisa edit profil merchant
        if ($user->user_level_id != 3) {
            return $this->error('Unauthorized', 403);
        }

        $merchant = MerchantUser::where('user_id', $user->id)
            ->first();

        $merchant->update([
            'owner_name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'province_id' => $request->province_id,
            'city_id' => $request->city_id,
            'district_id' => $request->district_id,
            'village_id' => $request->village_id,
        ]);

        return $this->success($merchant, 'User profile updated successfully');
    }

    /**
     * Get Profile Parents by auth
     */
    public function profileParents(Request $request)
    {
        $user = $request->user();

        // JIKA USER LEVEL BUKAN SEBAGAI PARENT / 5 MAKA TIDAK BISA AKSES PROFIL PARENTS
        if ($user->user_level_id != 5) {
            return $this->error('Anda tidak diizinkan mengakses profil orang tua', 403);
        }

        $parent = Parents::where('user_id', $user->id)->first(); // ambil id parent
        $children = Student::where('parent_id', $parent->id)->get(); // ambil data anak berdasarkan id parent
        $parentFather = Parents::where('student_id', $children->pluck('id')); // ambil data ayah berdasarkan

        $parentFather->children = $children; // tambahkan data anak ke dalam response

        $parentFather->province_name = $parentFather->province ? $parentFather->province->name : null;
        $parentFather->city_name = $parentFather->city ? $parentFather->city->name : null;
        $parentFather->district_name = $parentFather->district ? $parentFather->district->name : null;
        $parentFather->village_name = $parentFather->village ? $parentFather->village->name : null;

        // ambil data ibu berdasarkan id anak yang sama dengan id anak yang dimiliki oleh ayah
        $parentMother = Parents::where('student_id', $children->pluck('id'))->where('gender', 'perempuan')->first(); // ambil data ibu berdasarkan
        $parentMother->children = $children; // tambahkan data anak ke dalam response

        $parentMother->province_name = $parentMother->province ? $parentMother->province->name : null;
        $parentMother->city_name = $parentMother->city ? $parentMother->city->name : null;
        $parentMother->district_name = $parentMother->district ? $parentMother->district->name : null;
        $parentMother->village_name = $parentMother->village ? $parentMother->village->name : null;

        $data = [
            'father' => $parentFather,
            'mother' => $parentMother,
            'children' => $children
        ];

        return $this->success($data, 'User profile retrieved successfully');
    }

    /**
     * Reset Password by auth
     */
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

        return response()->json([
            'success' => true,
            'message' => 'Password updated successfully',
        ], 200);
    }

    /**
     * Change PIN by auth
     */
    public function changePin(Request $request)
    {
        $request->validate([
            'nis' => 'required',
            'current_pin' => 'required|digits:4',
            'new_pin' => 'required|digits:4|confirmed',
        ]);
        $student = Student::where('nis', $request->nis)->first();
        if (!$student) {
            return $this->error('Student not found', 404);
        }

        if (!\Hash::check($request->current_pin, $student->pin)) {
            return $this->error('Current PIN is incorrect', 422);
        }

        $student->pin = \Hash::make($request->new_pin);
        $student->save();
        return response()->json([
            'success' => true,
            'message' => 'PIN updated successfully',
        ], 200);
    }
}
