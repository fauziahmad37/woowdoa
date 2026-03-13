<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Merchant;
use App\Models\MerchantUser;
use App\Models\UserLevel;
use App\Models\Province;
use App\Models\City;
use App\Models\District;
use App\Models\Village;
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

    // FORM CREATE
 public function create()
{
    $merchants = Merchant::all();

    $user_levels = UserLevel::whereIn('user_level_id',[2,3])->get();

    return view('merchant_user.create', compact(
        'merchants',
        'user_levels'
    ));
}

    // STORE
    public function store(Request $request)
    {

        $request->validate([
            'owner_name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'user_type' => 'required',
            'merchant_id' => 'required'
        ]);

        DB::beginTransaction();

        try {

            MerchantUser::create([
                'owner_name' => $request->owner_name,
                'email' => $request->email,
                'phone' => $request->phone,
                'address' => $request->address,
                'merchant_id' => $request->merchant_id,
                'province_id' => $request->province_id,
                'city_id' => $request->city_id,
                'district_id' => $request->district_id,
                'village_id' => $request->village_id,
                'user_type' => $request->user_type,
                'is_active' => true
            ]);

            DB::commit();

            return redirect()
                ->route('merchant.user.index',$request->merchant_id)
                ->with('success','User merchant berhasil dibuat');

        } catch (\Exception $e) {

            DB::rollBack();
            return back()->withErrors($e->getMessage());

        }
    }


    // EDIT
    public function edit($id)
    {
        $user = MerchantUser::findOrFail($id);

        $merchant = Merchant::findOrFail($user->merchant_id);

        $provinsi = Province::all();

        $kota = City::where('province_id',$user->province_id)->get();

        $kecamatan = District::where('regency_id',$user->city_id)->get();

        $kelurahan = Village::where('district_id',$user->district_id)->get();

        $user_levels = UserLevel::whereIn('user_level_id',[2,3])->get();

        return view('merchant.user.edit', compact(
            'user',
            'merchant',
            'provinsi',
            'kota',
            'kecamatan',
            'kelurahan',
            'user_levels'
        ));
    }


    // UPDATE
    public function update(Request $request, $id)
    {

        $user = MerchantUser::findOrFail($id);

        $request->validate([
            'owner_name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'user_type' => 'required'
        ]);

        DB::beginTransaction();

        try {

            $user->update([
                'owner_name' => $request->owner_name,
                'email' => $request->email,
                'phone' => $request->phone,
                'address' => $request->address,
                'province_id' => $request->province_id,
                'city_id' => $request->city_id,
                'district_id' => $request->district_id,
                'village_id' => $request->village_id,
                'user_type' => $request->user_type
            ]);

            DB::commit();

            return redirect()
                ->route('merchant.user.index',$user->merchant_id)
                ->with('success','User merchant berhasil diupdate');

        } catch (\Exception $e) {

            DB::rollBack();
            return back()->withErrors($e->getMessage());

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
