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
use App\Models\MerchantCategory;
use App\Models\Bank;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;


class MerchantController extends Controller
{
public function index(Request $request)
{
 $query = Merchant::where('is_active', 't')
    ->where('school_id', auth()->user()->school_id)

    // TOTAL SALDO (ewallets)
->addSelect([
    'total_saldo' => DB::table('ewallets')
        ->join('users', 'users.id', '=', 'ewallets.user_id')
        ->selectRaw('COALESCE(SUM(ewallets.balance),0)')
        ->whereColumn('users.merchant_id', 'merchants.id')
        ->where('users.user_level_id', 2) 
        ->where('ewallets.wallet_type', 'merchant') // ⚠️ sesuaikan value
])
    // TOTAL TRANSAKSI (transactions)
    ->addSelect([
        'total_transaksi' => DB::table('transactions')
            ->selectRaw('COALESCE(SUM(total_amount),0)')
            ->whereColumn('merchant_id', 'merchants.id')
    ])

    // TOTAL PENDING (settlements)
    ->addSelect([
        'total_pending' => DB::table('settlements')
            ->selectRaw('COALESCE(SUM(amount),0)')
            ->whereColumn('merchant_id', 'merchants.id')
            ->where('status', 'pending')
    ]);

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
     $banks     = Bank::all();
    $merchant_categories = MerchantCategory::all();

    $schools = School::where('is_active', true)->get();  
    return view('merchant.create', compact('schools','provinsi','kota','merchant_categories','banks'));
}

public function store(Request $request)
{
 $request->validate([
    'merchant_code' => 'required|unique:merchants,merchant_code',
    'merchant_name' => 'required',
    'phone' => 'required|unique:merchants,phone',
    'email' => 'required|email|unique:merchants,email',
    'school_id' => 'required',
    'merchant_category_id' => 'required',
    'merchant_id_provinsi' => 'required',
    'merchant_id_kota' => 'required',
    'merchant_id_kecamatan' => 'required',
    'merchant_id_kelurahan' => 'required',
    'bank_id' => 'required',
    'nomor_rekening' => 'required',
    'atas_nama_norek' => 'required',
     'no_npwp' => 'required',
    'logo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
]);

    DB::beginTransaction();
$logoPath = null;

if ($request->hasFile('logo')) {
    $path = $request->file('logo')->store('merchant_logo', 'public');

    $logoPath = 'storage/' . $path; 
}
    try { 
        // 1️⃣ Insert ke merchant
    $merchant = Merchant::create([
    'merchant_code' => $request->merchant_code,
    'merchant_name' => $request->merchant_name,
    'phone' => $request->phone,
    'email' => $request->email,
    'school_id' => $request->school_id,
    'merchant_category_id' => $request->merchant_category_id,
    'province_id' => $request->merchant_id_provinsi,
    'city_id' => $request->merchant_id_kota,
    'district_id' => $request->merchant_id_kecamatan,
    'village_id' => $request->merchant_id_kelurahan,
     'bank_id' => $request->bank_id,
    'nomor_rekening' => $request->nomor_rekening,
    'atas_nama_norek' => $request->atas_nama_norek,
    'address' => $request->address,
    'no_npwp' => $request->no_npwp,
    'logo' => $logoPath
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

    $kota = City::where('province_id', $merchant->province_id)->get();

    $kecamatan = District::where('regency_id', $merchant->city_id)->get();

    $kelurahan = Village::where('district_id', $merchant->district_id)->get();
  $banks     = Bank::all();
    $schools = School::where('is_active', true)->get();
    $merchant_categories = MerchantCategory::all();

    return view('merchant.edit', compact(
        'merchant',
        'provinsi',
        'kota',
        'kecamatan',
        'kelurahan',
        'schools',
        'merchant_categories',
        'banks'
    ));
}

public function update(Request $request, Merchant $merchant)
{
    $request->validate([
        'merchant_code' => 'required|unique:merchants,merchant_code,' . $merchant->id,
        'merchant_name' => 'required',
        'phone' => 'required|unique:merchants,phone,' . $merchant->id,
        'email' => 'required|email|unique:merchants,email,' . $merchant->id,
        'school_id' => 'required',
        'merchant_category_id' => 'required',
        'merchant_id_provinsi' => 'required',
        'merchant_id_kota' => 'required',
        'merchant_id_kecamatan' => 'required',
        'merchant_id_kelurahan' => 'required',
         'bank_id' => 'required',
    'nomor_rekening' => 'required',
    'atas_nama_norek' => 'required',
       'no_npwp' => 'required',
        'logo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
    ]);

    DB::beginTransaction();

    try {
$logoPath = $merchant->logo;

// jika upload logo baru
if ($request->hasFile('logo')) {

    // hapus logo lama (fix path)
    if ($merchant->logo) {
        $oldPath = str_replace('storage/', '', $merchant->logo);

        if (Storage::disk('public')->exists($oldPath)) {
            Storage::disk('public')->delete($oldPath);
        }
    }

    // upload logo baru
    $path = $request->file('logo')->store('merchant_logo', 'public');

    $logoPath = 'storage/' . $path; //  prefix storage
}

        $merchant->update([
            'merchant_code' => $request->merchant_code,
            'merchant_name' => $request->merchant_name,
            'phone' => $request->phone,
            'email' => $request->email,
            'school_id' => $request->school_id,
            'merchant_category_id' => $request->merchant_category_id,
            'province_id' => $request->merchant_id_provinsi,
            'city_id' => $request->merchant_id_kota,
            'district_id' => $request->merchant_id_kecamatan,
            'village_id' => $request->merchant_id_kelurahan,
            'address' => $request->address,
              'bank_id' => $request->bank_id,
    'nomor_rekening' => $request->nomor_rekening,
    'atas_nama_norek' => $request->atas_nama_norek,
     'no_npwp' => $request->no_npwp,
            'logo' => $logoPath
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