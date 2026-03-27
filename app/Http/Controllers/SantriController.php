<?php

namespace App\Http\Controllers;

use App\Models\Santri;
use App\Models\School;
use App\Models\SchoolClass;
use App\Models\TahunAjaran;
use App\Models\Province;
use App\Models\City;
use App\Models\District; 
use App\Models\Village;
use App\Models\Parents; 
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use App\Imports\SantriImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Auth;

class SantriController extends Controller
{
public function index(Request $request)
{
   $query = Santri::select(
            'students.*',
            'ewallets.balance',
            'ewallets.updated_at as ewallet_updated_at',
            'ewallets.created_at as ewallet_created_at'
        )
        ->where('students.is_delete', false)
        ->where('students.school_id', Auth::user()->school_id)
        ->leftJoin('ewallets', 'ewallets.user_id', '=', 'students.id')
        ->orderBy('students.created_at', 'desc');

    if ($request->search) {
        $query->where(function ($q) use ($request) {
            $q->where('students.nis', 'ilike', '%'.$request->search.'%')
              ->orWhere('students.student_name', 'ilike', '%'.$request->search.'%');
        });
    }

    $student = $query->paginate(10);

    return view('santri.index', compact('student'));
}

public function create()
{
    $santri = null;

    $schools = School::where('is_active', true)->get();
<<<<<<< Updated upstream
  $parents = Parents::where('is_delete', false)
=======
  $parents = StudentParent::where('is_delete', false)
>>>>>>> Stashed changes
    ->where('school_id', Auth::user()->school_id)
    ->get();
    $tahunAjarans = TahunAjaran::where('is_active', true)->get();
    $classes = SchoolClass::where('school_id', Auth::user()->school_id)
    ->get();

    return view('santri.create', compact(
        'santri',
        'schools',
        'parents',
        'tahunAjarans',
        'classes'
    ));
}

public function store(Request $request)
{
    $request->validate([
        'nis' => 'required|unique:students,nis',
        'student_name' => 'required',
        'username' => 'required|unique:users,username',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|min:6',
        'pin' => 'required|min:4',
        'school_id' => 'required|exists:schools,id',
        'tahun_ajaran_id' => 'required|exists:tahun_ajaran,id',
        'class_id' => 'required|exists:classes,id',

        // 🔥 parent
        'nik' => 'required',
    ]);

    DB::beginTransaction();

    try {

        // =========================
        // 🔥 1. CEK / CREATE PARENT
        // =========================
        $parent = Parents::where('nik', $request->nik)->first();

        if (!$parent) {

            // upload foto parent
            $parentPhoto = null;
            if ($request->hasFile('parent_profile_photo')) {
                $parentPhoto = $request->file('parent_profile_photo')
                    ->store('profile_photo', 'public');
            }

            // create user parent
            $parentUser = User::create([
                'complete_name' => $request->parent_name,
                'username' => $request->parent_username,
                'phone' => $request->parent_phone,
                'email' => $request->parent_email,
                'school_id' => $request->parent_school_id ?? $request->school_id,
                'profile_photo' => $parentPhoto,
                'is_active' => $request->parent_active ?? 1,
                'user_level_id' => 5,
                'password' => Hash::make($request->parent_password ?? '123456'),
            ]);

            // create parent
            $parent = Parents::create([
                'nik' => $request->nik,
                'parent_name' => $request->parent_name,
                'parent_phone' => $request->parent_phone,
                'school_id' => $request->parent_school_id ?? $request->school_id,
                'address' => $request->parent_address,
                'user_id' => $parentUser->id,
                'active' => $request->parent_active ?? 1,
                'gender' => $request->parent_gender,
            ]);
        }

        // =========================
        // 🔥 2. SANTRI PHOTO
        // =========================
        $photoPath = null;
        if ($request->hasFile('profile_photo')) {
            $photoPath = $request->file('profile_photo')
                ->store('profile_photo', 'public');
        }

        // =========================
        // 🔥 3. USER SANTRI
        // =========================
        $user = User::create([
            'complete_name' => $request->student_name,
            'username' => $request->username,
            'user_level_id' => 6,
            'phone' => $request->phone,
            'email' => $request->email,
            'profile_photo' => $photoPath,
            'school_id' => $request->school_id,
            'password' => Hash::make($request->password),
            'is_active' => $request->active,
        ]);

        // =========================
        // 🔥 4. SANTRI
        // =========================
        Santri::create([
            'nis' => $request->nis,
            'student_name' => $request->student_name,
            'class_id' => $request->class_id,
            'gender' => $request->gender,
            'address' => $request->address,
            'phone' => $request->phone,
            'email' => $request->email,
            'school_id' => $request->school_id,
            'active' => $request->active,
            'parent_id' => $parent->id, // 🔥 AUTO LINK
            'user_id' => $user->id,
            'tahun_ajaran_id' => $request->tahun_ajaran_id,
            'pin' => Hash::make($request->pin),
        ]);

        DB::commit();

        return redirect()->route('santri.create')
            ->with('success', 'Santri berhasil ditambahkan');

    } catch (\Exception $e) {
        DB::rollBack();
        return back()->withErrors($e->getMessage());
    }
} 

public function edit(Santri $santri)
{
    
    $santri->load('user', 'parent.user');

    $schools = School::where('is_active', true)->get();
<<<<<<< Updated upstream

    $parents = Parents::where('is_delete', false)
        ->where('school_id', Auth::user()->school_id)
        ->get();

    $tahunAjarans = TahunAjaran::where('is_active', true)->get();

    $classes = SchoolClass::where('school_id', Auth::user()->school_id)
        ->get();
=======
  $parents = StudentParent::where('is_delete', false)
    ->where('school_id', Auth::user()->school_id)
    ->get();
    $tahunAjarans = TahunAjaran::where('is_active', true)->get();
    $classes = SchoolClass::where('school_id', Auth::user()->school_id)
    ->get();

>>>>>>> Stashed changes

    return view('santri.edit', compact(
        'santri',
        'schools',
        'parents',
        'tahunAjarans',
        'classes'
    ));
}


public function update(Request $request, Santri $santri)
{
    $request->validate([
        'nis' => 'required|unique:students,nis,' . $santri->id,
        'student_name' => 'required',
        'username' => 'required|unique:users,username,' . $santri->user_id,
        'email' => 'required|email|unique:users,email,' . $santri->user_id,
        'password' => 'nullable|min:6',
        'pin' => 'nullable|min:4',
        'school_id' => 'required|exists:schools,id',
        'tahun_ajaran_id' => 'required|exists:tahun_ajaran,id',
        'class_id' => 'required|exists:classes,id',

        // 🔥 pakai NIK seperti store
        'nik' => 'required',
    ]);

    DB::beginTransaction();

    try {

        // =========================
        // 🔥 1. CEK / CREATE / UPDATE PARENT
        // =========================
        $parent = Parents::where('nik', $request->nik)->first();

        if (!$parent) {

            // create parent baru
            $parentUser = User::create([
                'complete_name' => $request->parent_name,
                'username' => $request->parent_username,
                'phone' => $request->parent_phone,
                'email' => $request->parent_email,
                'school_id' => $request->parent_school_id ?? $request->school_id,
                'user_level_id' => 5,
                'password' => Hash::make($request->parent_password ?? '123456'),
                'is_active' => $request->parent_active ?? 1,
            ]);

            $parent = Parents::create([
                'nik' => $request->nik,
                'parent_name' => $request->parent_name,
                'parent_phone' => $request->parent_phone,
                'school_id' => $request->parent_school_id ?? $request->school_id,
                'address' => $request->parent_address,
                'user_id' => $parentUser->id,
                'active' => $request->parent_active ?? 1,
                'gender' => $request->parent_gender,
            ]);

        } else {

            // 🔥 UPDATE parent jika sudah ada
            $parent->update([
                'parent_name' => $request->parent_name,
                'parent_phone' => $request->parent_phone,
                'school_id' => $request->parent_school_id ?? $request->school_id,
                'address' => $request->parent_address,
                'active' => $request->parent_active ?? 1,
                'gender' => $request->parent_gender,
            ]);

            // update user parent
            if ($parent->user) {
                $parent->user->update([
                    'complete_name' => $request->parent_name,
                    'username' => $request->parent_username,
                    'phone' => $request->parent_phone,
                    'email' => $request->parent_email,
                    'school_id' => $request->parent_school_id ?? $request->school_id,
                    'is_active' => $request->parent_active ?? 1,
                ]);

                if ($request->filled('parent_password')) {
                    $parent->user->update([
                        'password' => Hash::make($request->parent_password)
                    ]);
                }
            }
        }

        // =========================
        // 🔥 2. FOTO SANTRI
        // =========================
        $photoPath = $santri->user->profile_photo;

        if ($request->hasFile('profile_photo')) {
            $photoPath = $request->file('profile_photo')
                ->store('profile_photo', 'public');
        }

        // =========================
        // 🔥 3. UPDATE USER SANTRI
        // =========================
        $santri->user->update([
            'complete_name' => $request->student_name,
            'username' => $request->username,
            'phone' => $request->phone,
            'email' => $request->email,
            'school_id' => $request->school_id,
            'is_active' => $request->active,
            'profile_photo' => $photoPath,
        ]);

        if ($request->filled('password')) {
            $santri->user->update([
                'password' => Hash::make($request->password)
            ]);
        }

        // =========================
        // 🔥 4. UPDATE SANTRI
        // =========================
        $santri->update([
            'nis' => $request->nis,
            'student_name' => $request->student_name,
            'gender' => $request->gender,
            'address' => $request->address,
            'phone' => $request->phone,
            'email' => $request->email,
            'active' => $request->active,
            'school_id' => $request->school_id,
            'parent_id' => $parent->id, 
            'class_id' => $request->class_id,
            'tahun_ajaran_id' => $request->tahun_ajaran_id,
        ]);

        if ($request->filled('pin')) {
            $santri->update([
                'pin' => Hash::make($request->pin)
            ]);
        }

        DB::commit();

        return redirect()->route('santri.index')
            ->with('success', 'Santri berhasil diupdate');

    } catch (\Exception $e) {

        DB::rollBack();
        return back()->withErrors($e->getMessage());
    }
}
public function destroy(Santri $santri)
{
    $now = Carbon::now();

    // Update santri
    $santri->update([
        'is_delete'  => true,
        'deleted_at' => $now,
    ]);

    // Update user terkait (jika ada relasi)
    if ($santri->user) {
        $santri->user->update([
            'is_delete'  => true,
            'deleted_at' => $now,
        ]);
    }

    return back()->with('success', 'Santri berhasil dihapus');
}


public function importForm()
{
    return view('santri.import');
}

public function import(Request $request)
{
    $request->validate([
        'file' => 'required|mimes:xlsx,xls'
    ]);

    Excel::import(new SantriImport, $request->file('file'));

    return redirect()->route('santri.index')
        ->with('success','Data santri berhasil diimport');
}

	public function search(Request $request)
	{
		$search = $request->q;
		$students = Santri::where('nis','like',"%$search%")
				->orWhere('student_name','like',"%$search%")
				->limit(10)
				->get();
		$data = [];
		foreach($students as $s){
				$data[] = [
						'id'=>$s->nis,
						'text'=>$s->nis.' - '.$s->student_name
				];
		}
		return response()->json([
				'results'=>$data
		]);

	}
}