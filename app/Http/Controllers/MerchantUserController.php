<?php

namespace App\Http\Controllers;

use App\Models\Province;
use App\Models\City;
use App\Models\District; 
use App\Models\Village;
use Illuminate\Http\Request;
use App\Models\Merchant;
use App\Models\MerchantUser;
use App\Models\UserLevel;
use App\Models\School;

use DB;

class MerchantUserController extends Controller
{

    // LIST USER MERCHANT
public function index(Request $request)
{
    $users = MerchantUser::with('merchant','level')
        ->when($request->search,function($q) use ($request){
            $q->where('owner_name','like','%'.$request->search.'%')
              ->orWhere('email','like','%'.$request->search.'%');
        })
        ->paginate(10);

    return view('merchant_user.index',compact('users'));
}



    public function create()
{
      $provinsi = Province::all();
    $kota     = City::all();
    $merchants = Merchant::all();
$levels = UserLevel::whereIn('user_level_id',[2,3])->get();
    $schools = DB::table('schools')->get();

    return view('merchant_user.create', compact(
        'merchants',
        'levels',
        'schools',
        'provinsi',
        'kota'
    ));
}

    public function store(Request $request)
{
    DB::beginTransaction();

    try {

        // upload foto
        $photo = null;
        if($request->hasFile('profile_photo')){
            $photo = $request->file('profile_photo')->store('profile','public');
        }

        // ======================
        // 1. INSERT KE USERS
        // ======================
       $request->validate([
    'owner_name' => 'required',
    'username' => 'required',
    'merchant_id' => 'required',
    'user_type' => 'required',
     'password' => 'required|min:6',
]);
     $userId = DB::table('users')->insertGetId([
    'complete_name' => $request->owner_name,
    'username'      => $request->username,
    'email'         => $request->email,
    'phone'         => $request->phone,
    'password'      => bcrypt($request->password),
    'profile_photo' => $photo,
    'merchant_id'   => $request->merchant_id,
    'school_id'     => $request->school_id,
    'user_level_id' => $request->user_type,
    'created_at'    => now(),
    'updated_at'    => now()
]);
        // ======================
        // 2. INSERT MERCHANT USER
        // ======================
        MerchantUser::create([
            'owner_name' => $request->owner_name,
            'email'      => $request->email,
            'phone'      => $request->phone,
            'merchant_id'=> $request->merchant_id,
            'user_type'  => $request->user_type,
            'user_id'    => $userId,
              // alamat wilayah
    'province_id'   => $request->province_id,
    'city_id'       => $request->city_id,
    'district_id'   => $request->district_id,
    'village_id'    => $request->village_id,
    'address'       => $request->address

        ]);

        // ======================
        // 3. UPDATE MERCHANT
        // ======================
        DB::table('merchants')
            ->where('id',$request->merchant_id)
            ->update([
                'owner_name' => $request->owner_name
            ]);

        DB::commit();

        return redirect()
            ->route('merchant.user.index')
            ->with('success','User merchant berhasil dibuat');

    } catch (\Exception $e){

    DB::rollback();

  
}
}


// edit

public function edit($id)
{
    $user = MerchantUser::findOrFail($id);
    $merchant = $user->merchant;

    $provinsi = Province::all();

    $kota = City::where('province_id', $merchant->province_id)->get();
    $kecamatan = District::where('regency_id', $merchant->city_id)->get();
    $kelurahan = Village::where('district_id', $merchant->district_id)->get();

    $schools = School::where('is_active', true)->get();
    $merchants = Merchant::all();
    $levels = UserLevel::whereIn('user_level_id',[2,3])->get();

    return view('merchant_user.edit', compact(
        'user',
        'provinsi',
        'kota',
        'kecamatan',
        'kelurahan',
        'merchants',
        'levels',
        'schools'
    ));
}
// update
public function update(Request $request, $id)
{
    DB::beginTransaction();

    try {

        $user = MerchantUser::findOrFail($id);

        $request->validate([
            'owner_name' => 'required',
            'username' => 'required',
            'merchant_id' => 'required',
            'user_type' => 'required',
            'password' => 'nullable|min:6'
        ]);

        // ======================
        // SIAPKAN DATA USER
        // ======================
        $dataUser = [
            'complete_name' => $request->owner_name,
            'username'      => $request->username,
            'email'         => $request->email,
            'phone'         => $request->phone,
            'merchant_id'   => $request->merchant_id,
            'school_id'     => $request->school_id,
            'user_level_id' => $request->user_type,
            'updated_at'    => now()
        ];

        // jika password diisi
        if($request->password){
            $dataUser['password'] = bcrypt($request->password);
        }

        // jika upload foto
        if($request->hasFile('profile_photo')){
            $dataUser['profile_photo'] =
                $request->file('profile_photo')->store('profile','public');
        }

        // ======================
        // UPDATE USERS TABLE
        // ======================
        DB::table('users')
            ->where('id',$user->user_id)
            ->update($dataUser);

        // ======================
        // UPDATE MERCHANT USER
        // ======================
        $user->update([
            'owner_name' => $request->owner_name,
            'email'      => $request->email,
            'phone'      => $request->phone,
            'merchant_id'=> $request->merchant_id,
            'user_type'  => $request->user_type,
            'province_id'=> $request->province_id,
            'city_id'    => $request->city_id,
            'district_id'=> $request->district_id,
            'village_id' => $request->village_id,
            'address'    => $request->address
        ]);

        DB::commit();

        return redirect()
            ->route('merchant.user.index')
            ->with('success','User merchant berhasil diupdate');

    } catch (\Exception $e){

        DB::rollback();

        dd($e->getMessage());
    }
}
    // DELETE
    public function destroy($id)
    {
        $user = MerchantUser::findOrFail($id);

        $merchant_id = $user->merchant_id;

        $user->delete();

        return redirect()
            ->route('merchant.user.index',$merchant_id)
            ->with('success','User merchant berhasil dihapus');
    }

}
