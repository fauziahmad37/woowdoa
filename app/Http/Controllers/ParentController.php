<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\School;
use App\Models\StudentParent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ParentImport;

class ParentController extends Controller
{
    /* =========================
       INDEX
    ========================== */
public function index(Request $request)
{
    $query = StudentParent::with('user', 'school')
                ->where('is_delete', false)
                ->where('school_id', Auth::user()->school_id); // filter sekolah

    if ($request->search) {
        $query->where(function ($q) use ($request) {
            $q->where('parent_name', 'like', '%'.$request->search.'%')
              ->orWhereHas('user', function ($q2) use ($request) {
                  $q2->where('email', 'like', '%'.$request->search.'%');
              });
        });
    }

    $parents = $query->latest()->paginate(10);

    return view('parent.index', compact('parents'));
}

    /* =========================
       CREATE
    ========================== */
public function create()
{
    $parent = new StudentParent();
      $schools = School::where('is_active', true)->get();

    return view('parent.form', compact('parent', 'schools'));
}

    /* =========================
       STORE
    ========================== */
   public function store(Request $request)
{
    $request->validate([
        'parent_name' => 'required',
        'username' => 'required|unique:users,username',
        'email' => 'required|email|unique:users,email',
        'phone' => 'required',
        'password' => 'required|min:6',
        'school_id' => 'required|exists:schools,id',
        'active' => 'required|in:0,1',
        'address' => 'nullable|string',
        'profile_photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    DB::beginTransaction();

    try {

        // Upload foto
        $photoPath = null;
        if ($request->hasFile('profile_photo')) {
            $photoPath = $request->file('profile_photo')
                ->store('profile_photo', 'public');
        }

        // Insert ke users
        $user = User::create([
            'complete_name' => $request->parent_name,
            'username' => $request->username,
            'phone' => $request->phone,
            'email' => $request->email,
            'school_id' => $request->school_id,
            'profile_photo' => $photoPath,
            'is_active' => $request->active,
            'user_level_id' => 5,
            'password' => Hash::make($request->password),
        ]);

        // Insert ke student_parents
        StudentParent::create([
            'parent_name' => $request->parent_name,
             'parent_phone'  => $request->phone,
              'school_id' => $request->school_id,
            'address' => $request->address,
            'user_id' => $user->id,
            'active' => $request->active,
        ]);

        DB::commit();

          return redirect()
        ->route('parent.create')
        ->with('success', 'Data orangtua berhasil ditambahkan.');

    } catch (\Exception $e) {
        DB::rollBack();
        return back()->withErrors($e->getMessage());
    }
}

    /* =========================
       EDIT
    ========================== */
    public function edit(StudentParent $parent)
    {
        $parent->load('user');

        $schools = School::where('is_active', true)->get();

        return view('parent.edit', compact('parent', 'schools'));
    }

    /* =========================
       UPDATE
    ========================== */
   public function update(Request $request, StudentParent $parent)
{
    $request->validate([
        'parent_name' => 'required',
        'username' => 'required|unique:users,username,' . $parent->user_id,
        'email' => 'required|email|unique:users,email,' . $parent->user_id,
        'password' => 'nullable|min:6',
        'school_id' => 'required|exists:schools,id',
        'active' => 'required|in:0,1',
        'address' => 'nullable|string',
        'profile_photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    DB::beginTransaction();

    try {

        $photoPath = $parent->user->profile_photo;

        if ($request->hasFile('profile_photo')) {

            // Hapus foto lama
            if ($photoPath) {
                Storage::disk('public')->delete($photoPath);
            }

            $photoPath = $request->file('profile_photo')
                ->store('profile_photo', 'public');
        }

        // Update users
        $parent->user->update([
            'complete_name' => $request->parent_name,
            'username' => $request->username,
            'phone' => $request->phone,
            'email' => $request->email,
            'school_id' => $request->school_id,
            'is_active' => $request->active,
            'profile_photo' => $photoPath,
        ]);

        if ($request->filled('password')) {
            $parent->user->update([
                'password' => Hash::make($request->password),
            ]);
        }

        // Update parent
        $parent->update([
            'parent_name' => $request->parent_name,
            'parent_phone'  => $request->phone,
             'school_id' => $request->school_id,
            'address' => $request->address,
            'active' => $request->active,
        ]);

        DB::commit();

        return redirect()->route('parent.index')
            ->with('success', 'Orangtua berhasil diupdate');

    } catch (\Exception $e) {
        DB::rollBack();
        return back()->withErrors($e->getMessage());
    }
}

    /* =========================
       DELETE
    ========================== */
  public function destroy(StudentParent $parent)
  
{
    DB::transaction(function () use ($parent) {
 $now = Carbon::now();

        // Update parents table
        $parent->update([
            'is_delete'  => true,
            'deleted_at' => now(),
        ]);

        // Update users table (jika ada relasi)
        if ($parent->user) {
            $parent->user->update([
                'is_delete'  => true,
                'deleted_at' => now(),
            ]);
        }
    });

    return back()->with('success', 'Orangtua berhasil dihapus');
}


// import

public function importForm()
{
    return view('parent.import');
}

public function import(Request $request)
{
    $request->validate([
        'file' => 'required|mimes:xlsx,xls'
    ]);

    Excel::import(new ParentImport, $request->file('file'));

    return redirect()->route('parent.index')
        ->with('success','Data orang tua berhasil diimport');
}
}