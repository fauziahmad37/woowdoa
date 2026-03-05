<?php

namespace App\Http\Controllers;

use App\Models\Santri;
use App\Models\School;
use App\Models\SchoolClass;
use App\Models\TahunAjaran;
use App\Models\StudentParent; 
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use App\Imports\SantriImport;
use Maatwebsite\Excel\Facades\Excel;

class SantriController extends Controller
{
public function index(Request $request)
{
    $query = Santri::where('is_delete', false);

    if ($request->search) {
        $query->where(function ($q) use ($request) {
            $q->where('nis', 'ilike', '%'.$request->search.'%')
              ->orWhere('student_name', 'ilike', '%'.$request->search.'%');
        });
    }

    $student = $query->latest()->paginate(10);

    return view('santri.index', compact('student'));
}

public function create()
{
    $santri = null;

    $schools = School::where('is_active', true)->get();
    $parents = StudentParent::where('is_delete', false)->get();
    $tahunAjarans = TahunAjaran::where('is_active', true)->get();
    $classes = SchoolClass::all();

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
        'parent_id' => 'nullable|exists:parents,id',
        'profile_photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
'tahun_ajaran_id' => 'required|exists:tahun_ajaran,id',
'class_id' => 'required|exists:classes,id',
    ]);

    DB::beginTransaction();

    try {

        // Upload Foto (kalau ada)
        $photoPath = null;
        if ($request->hasFile('profile_photo')) {
            $photoPath = $request->file('profile_photo')
                ->store('profile_photo', 'public');
        }

        // 1️⃣ Insert ke users
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

        // 2️⃣ Insert ke students
        Santri::create([
            'nis' => $request->nis,
            'student_name' => $request->student_name,
             'class_id' => $request->class_id, 
            'gender' => $request->gender,
            'address' => $request->address,
            'phone' => $request->phone,
            'email' => $request->email,
            // 'saldo' => $request->saldo ?? 0,
            'school_id' => $request->school_id,
            'active' => $request->active,
            'parent_id' => $request->parent_id,
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
    $santri->load('user');

    $schools = School::where('is_active', true)->get();
   $parents = StudentParent::where('is_delete', false)->get();
    $tahunAjarans = TahunAjaran::where('is_active', true)->get();
    $classes = SchoolClass::all();

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
        'parent_id' => 'nullable|exists:parents,id',
        'tahun_ajaran_id' => 'required|exists:tahun_ajaran,id',
        'class_id' => 'required|exists:classes,id',
        'profile_photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    DB::beginTransaction();

    try {

        // 🔹 Upload foto baru (jika ada)
        $photoPath = $santri->user->profile_photo;

        if ($request->hasFile('profile_photo')) {
            $photoPath = $request->file('profile_photo')
                ->store('profile_photo', 'public');
        }

        // 🔹 Update tabel users
        $santri->user->update([
            'complete_name' => $request->student_name,
            'username' => $request->username,
            'phone' => $request->phone,
            'email' => $request->email,
            'school_id' => $request->school_id,
            'is_active' => $request->active,
            'profile_photo' => $photoPath,
            
        ]);

        // 🔹 Update password jika diisi
        if ($request->filled('password')) {
            $santri->user->update([
                'password' => Hash::make($request->password)
            ]);
        }

        // 🔹 Update tabel students
        $santri->update([
            'nis' => $request->nis,
            'student_name' => $request->student_name,
            'gender' => $request->gender,
            'address' => $request->address,
            'phone' => $request->phone,
            'email' => $request->email,
            // 'saldo' => $request->saldo ?? 0,
            'active' => $request->active,
            'school_id' => $request->school_id,
            'parent_id' => $request->parent_id,
            'class_id' => $request->class_id,
            'tahun_ajaran_id' => $request->tahun_ajaran_id,
        ]);

        // 🔹 Update PIN jika diisi
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

}