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
use App\Models\User;

use DB;

class MerchantUserController extends Controller
{

    // LIST USER MERCHANT
public function index(Request $request)
{
    $users = MerchantUser::with('merchant','level','user')
        ->whereHas('user', function ($q) {
            $q->where('school_id', auth()->user()->school_id);
        })
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

$kota = collect();
$kecamatan = collect();
$kelurahan = collect();

if(isset($user)){

    $kota = City::where('province_id', $user->province_id)->get();

    $kecamatan = District::where('regency_id', $user->city_id)->get();

    $kelurahan = Village::where('district_id', $user->district_id)->get();
}
 $merchants = Merchant::where('school_id', auth()->user()->school_id)->get();
$levels = UserLevel::whereIn('user_level_id',[2,3])->get();
    $schools = DB::table('schools')->get();

    return view('merchant_user.create', compact(
        'merchants',
        'levels',
        'schools',
        'provinsi',
        'kota',
        'kelurahan',
        'kecamatan'
    ));
}
public function store(Request $request)
{
    DB::beginTransaction();

    try {

        // VALIDASI
        $request->validate([
            'owner_name' => 'required',
            'username'   => 'required',
            'merchant_id'=> 'required',
            'user_type'  => 'required',
            'password'   => 'required|min:6',
        ]);

        // upload foto
        $photo = null;
        if ($request->hasFile('profile_photo')) {
            $photo = $request->file('profile_photo')->store('profile','public');
        }

        // ======================
        // 1. INSERT KE USERS
        // ======================
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
            'province_id'=> $request->province_id,
            'city_id'    => $request->city_id,
            'district_id'=> $request->district_id,
            'village_id' => $request->village_id,
            'address'    => $request->address
        ]);

        // ======================
        // 3. UPDATE MERCHANT
        // hanya jika user_type = 2
        // ======================
        if ($request->user_type == 2) {

            DB::table('merchants')
                ->where('id', $request->merchant_id)
                ->update([
                    'owner_name' => $request->owner_name
                ]);

        }

        DB::commit();

        return redirect()
            ->route('merchant.user.index')
            ->with('success','User merchant berhasil dibuat');

    } catch (\Exception $e) {

        DB::rollBack();

        return back()->with('error', $e->getMessage());
    }
}


// edit

public function edit($id)
{
    
  $user = MerchantUser::with('user')->findOrFail($id);
// dd($user->id, $user->user_id);
    $userLogin = DB::table('users')
        ->where('id', $user->user_id)
        ->first();

    $provinsi = Province::all();

    $kota = City::where('province_id', $user->province_id)->get();
    $kecamatan = District::where('regency_id', $user->city_id)->get();
    $kelurahan = Village::where('district_id', $user->district_id)->get();

    $schools = School::where('is_active', true)->get();
 $merchants = Merchant::where('school_id', $user->user->school_id)->get();
    $levels = UserLevel::whereIn('user_level_id',[2,3])->get();


    
    return view('merchant_user.edit', compact(
        'user',
        'userLogin',
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
            'owner_name'  => 'required',
            'username'    => 'required',
            'merchant_id' => 'required',
            'user_type'   => 'required',
            'password'    => 'nullable|min:6'
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
        if ($request->password) {
            $dataUser['password'] = bcrypt($request->password);
        }

        // jika upload foto
        if ($request->hasFile('profile_photo')) {
            $dataUser['profile_photo'] =
                $request->file('profile_photo')->store('profile','public');
        }

        // ======================
        // UPDATE USERS TABLE
        // ======================
        DB::table('users')
            ->where('id', $user->user_id)
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
             'school_id'  => $request->school_id,
            'province_id'=> $request->province_id,
            'city_id'    => $request->city_id,
            'district_id'=> $request->district_id,
            'village_id' => $request->village_id,
            'address'    => $request->address
        ]);

        // ======================
        // UPDATE MERCHANT (jika owner)
        // ======================
        if ($request->user_type == 2) {

            DB::table('merchants')
                ->where('id', $request->merchant_id)
                ->update([
                    'owner_name' => $request->owner_name
                ]);

        }

        DB::commit();

        return redirect()
            ->route('merchant.user.index')
            ->with('success','User merchant berhasil diupdate');

    } catch (\Exception $e){

        DB::rollBack();

        return back()->with('error',$e->getMessage());
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
// Endpoint AJAX untuk cascading dropdown
public function getKota($province_id)
{
		$kota = City::where('province_id', $province_id)->get(['id','name']);
		return response()->json($kota);
}

public function getKecamatan($regency_id)
{
		$kecamatan = District::where('regency_id', $regency_id)->get(['id','name']);
		return response()->json($kecamatan);
}

public function getKelurahan($district_id)
{
		$kelurahan = Village::where('district_id', $district_id)->get(['id','name']);
		return response()->json($kelurahan);
}

}
