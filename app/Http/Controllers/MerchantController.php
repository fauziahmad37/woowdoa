<?php

namespace App\Http\Controllers;


use App\Models\Province;
use App\Models\City;
use App\Models\District; 
use App\Models\Village;
use App\Models\School;
use App\Models\SchoolClass;
use App\Models\Merchant;
use App\Models\User; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;



class MerchantController extends Controller
{
public function index(Request $request)
{
    $query = Merchant::where('is_active', 't');

    if ($request->search) {
        $query->where(function ($q) use ($request) {
            $q->where('merchant_code', 'ilike', '%'.$request->search.'%')
              ->orWhere('merchant_name', 'ilike', '%'.$request->search.'%');
        });
    }

    $merchant = $query->latest()->paginate(10);

    return view('merchant.index', compact('merchant'));
}

public function create()
{
    $merchant = null;
    $provinsi = Province::all();
    $kota     = City::all();
		
    $schools = School::where('is_active', true)->get();  
    return view('merchant.create', compact('schools','provinsi','kota'));
}

public function store(Request $request)
{
    $request->validate([
        'merchant_code' => 'required|unique:merchants,merchant_code',
        'merchant_name' => 'required',
        'phone' => 'required|unique:merchants,phone',
        'email' => 'required|email|unique:merchants,email', 
        'school_id' => 'required',  
				'merchant_id_provinsi' => 'required',
				'merchant_id_kota' => 'required',
				'merchant_id_kecamatan' => 'required',
				'merchant_id_kelurahan' => 'required'
    ]);

    DB::beginTransaction();

    try { 
        // 1️⃣ Insert ke merchant
        $merchant = Merchant::create([
            'merchant_code' => $request->merchant_code,
            'merchant_name' => $request->merchant_name,  
            'phone' => $request->phone,
            'email' => $request->email, 
            'school_id' => $request->school_id, 
            'province_id' => $request->merchant_id_provinsi, 
            'city_id' => $request->merchant_id_kota, 
            'district_id' => $request->merchant_id_kecamatan, 
            'village_id' => $request->merchant_id_kelurahan 
        ]);
 

        DB::commit();

      return redirect()->route('merchant.create')
    ->with('success', 'Merchant berhasil ditambahkan');

    } catch (\Exception $e) {

        DB::rollBack();
        return back()->withErrors($e->getMessage());
    }
}

public function edit(Merchant $merchant)
{
 
    $provinsi = Province::all();
    $kota     = City::all();
		
    $schools = School::where('is_active', true)->get();  

    return view('merchant.edit', compact('schools','provinsi','kota'));
}

public function update(Request $request, Merchant $merchant)
{
    $request->validate([
        'merchant_code' => 'required|unique:merchants,merchant_code',
        'merchant_name' => 'required',
        'phone' => 'required|unique:merchants,phone',
        'email' => 'required|email|unique:merchants,email', 
        'school_id' => 'required',  
				'merchant_id_provinsi' => 'required',
				'merchant_id_kota' => 'required',
				'merchant_id_kecamatan' => 'required',
				'merchant_id_kelurahan' => 'required'
    ]);

    DB::beginTransaction();

    try { 
        // 🔹 Update tabel merchant
        $merchant = Merchant::create([
            'merchant_code' => $request->merchant_code,
            'merchant_name' => $request->merchant_name,  
            'phone' => $request->phone,
            'email' => $request->email, 
            'school_id' => $request->school_id, 
            'province_id' => $request->merchant_id_provinsi, 
            'city_id' => $request->merchant_id_kota, 
            'district_id' => $request->merchant_id_kecamatan, 
            'village_id' => $request->merchant_id_kelurahan 
        ]);
				
        DB::commit();

        return redirect()->route('merchant.index')
            ->with('success', 'Merchant berhasil diupdate');

    } catch (\Exception $e) {

        DB::rollBack();
        return back()->withErrors($e->getMessage());
    }
}

public function destroy(Merchant $merchant)
{
    $now = Carbon::now();

    // Update merchant
    $merchant->update([
        'is_active'  => 'f',
        'deleted_at' => $now,
    ]);

 

    return back()->with('success', 'Merchant berhasil dihapus');
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