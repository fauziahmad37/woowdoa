<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserLevel;
use Illuminate\Http\Request; 
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
 
	public function index(Request $request)
	{ 	
		$query = User::with('level')->where('school_id',  Auth::user()->school_id);
    if ($request->search) {
        $search = $request->search;

        $query->where(function ($q) use ($search) {
            $q->where('username', 'ILIKE', "%{$search}%")
              ->orWhere('complete_name', 'ILIKE', "%{$search}%") 
              ->orWhere('email', 'ILIKE', "%{$search}%") 
              ->orWhere('phone', 'ILIKE', "%{$search}%");
							});

 						
        
    }
	
		$user = $query->latest()->paginate(20);
		return view('user.index', compact('user'));
 
	}
	
	
	public function create()
	{
		
    $user_levels = UserLevel::all();													
		return view('user.create',compact('user_levels')); 			
	}
	
	
	public function store(Request $request)
	{

		$request->validate([
				'complete_name' => 'required',
				'username' => 'required|unique:users,username',
				'phone' => 'required|phone|unique:users,phone',
				'email' => 'required|email|unique:users,email',
				'password' => 'nullable|min:6', 
				'profile_photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
		]);
		
		// Upload Foto (kalau ada)
		$photoPath = null;
		if ($request->hasFile('profile_photo')) {
				$photoPath = $request->file('profile_photo')
						->store('profile_photo', 'public');
		}
				
    User::create([
        'complete_name'=>$request->complete_name,
        'username'=>$request->username,
        'user_level_id'=>$request->user_level_id,
        'password'=>Hash::make($request->password),
        'phone'=>$request->phone,
        'email'=>$request->email,
        'profile_photo'=>$photoPath
    ]);
 
		return redirect()->route('User.index')->with('success', 'Pengajuan berhasil');
	}	
	

	public function edit(User $user)
	{ 
		$user_levels = UserLevel::all();			 
		return view('user.edit', compact('user','user_levels'));
	}
	
	public function update(Request $request, User $user)
	{
		$request->validate([ 
				'complete_name' => 'required',
				'username' => 'required|unique:users,username,' . $user->user_id,
				'phone' => 'required|unique:users,phone,' . $user->user_id,
				'email' => 'required|email|unique:users,email,' . $user->user_id,
				'password' => 'nullable|min:6', 
				'profile_photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
		]);
		

		$photoPath = $user->profile_photo;

		// jika upload photo baru
		if ($request->hasFile('profile_photo')) {
			// hapus photo lama
			if ($user->profile_photo && Storage::disk('public')->exists($user->profile_photo)) {
					Storage::disk('public')->delete($user->profile_photo);
			}

			// upload photo baru
			$photoPath = $request->file('profile_photo')->store('profile_photo', 'public');
		}
				
		// 🔹 Update password jika diisi
		if ($request->filled('password')) {
			$user->update([
					'password' => Hash::make($request->password)
			]); 
		}				
				
		$user->update([
        'complete_name'=>$request->complete_name,
        'username'=>$request->username,
        'user_level_id'=>$request->user_level_id, 
        'phone'=>$request->phone,
        'email'=>$request->email,
        'profile_photo'=>$photoPath
		]);		
		return redirect()->route('user.index')
										 ->with('success', 'User berhasil diupdate'); 		
	}		
	
	
	public function destroy(User $user)
	{
		$now = Carbon::now();

		// Update User
		$user->update([
				'is_active'  => 'f',
				'is_delete'  => 't',
				'deleted_at' => $now,
		]);

		return redirect()->route('user.index')
										 ->with('success', 'User berhasil dihapus'); 
	}

	
	public function userlevel()
	{
		$query = UserLevel::with('level');
    if ($request->search) {
			$search = $request->search;

			$query->where(function ($q) use ($search) {
					$q->where('user_level_name', 'ILIKE', "%{$search}%");
						}); 
    }
	
		$userlevel = $query->latest()->paginate(20);
		return view('user.userlevel', compact('userlevel'));		
	}
 
}
