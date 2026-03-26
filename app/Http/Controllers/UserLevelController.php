<?php

namespace App\Http\Controllers;
 
use App\Models\Menu;
use App\Models\UserLevel;
use Illuminate\Http\Request; 
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserLevelController extends Controller
{
 
	public function index(Request $request)
	{ 	
	
		$query = UserLevel::latest(); 
    if ($request->search) {
			$search = $request->search;

			$query->where(function ($q) use ($search) {
					$q->where('user_level_name', 'ILIKE', "%{$search}%");
						}); 
    }
	
		$userlevel = $query->paginate(20);
		return view('userlevel.index', compact('userlevel'));		
 
	}
	
	
	public function create()
	{
    $parents = Menu::where('menu_parent',  0)->get();			 
    $child = Menu::where('menu_parent','!=',  0)->get();			
		foreach ($parents as $parent) { 
			$parent->sub_menu = $child->where('menu_parent', $parent->menu_id);
		}
				
		return view('userlevel.create',compact('parents')); 			
	}
	
	public function store(Request $request)
	{
		$request->validate([
				'user_level_name' => 'required|unique:user_levels,user_level_name',
				'menu_ids'        => 'nullable|array',
		]);

		// Simpan data Level
		$userlevel = UserLevel::create([
				'user_level_name' => $request->user_level_name
		]);

		// Hubungkan dengan menu yang dipilih
		if ($request->has('menu_ids')) {
				$userlevel->menus()->attach($request->menu_ids);
		}

		return redirect()->route('userlevel.index')->with('success', 'Level berhasil ditambahkan');
	}
	
	public function update(Request $request, $id)
	{

    $request->validate([
        'user_level_name' => 'required|unique:user_levels,user_level_name,' . $id . ',user_level_id',
        'menu_ids'        => 'nullable|array',
    ]);		
 
		$userlevel = UserLevel::findOrFail($id);

		$userlevel->update([
				'user_level_name' => $request->user_level_name
		]);

     
    $userlevel->menus()->sync($request->menu_ids ?? []);
		 

		return redirect()->route('userlevel.index')
										 ->with('success', 'User Level berhasil diperbarui!');
	}	
  
	
	public function destroy($id)
	{
		$userlevel = UserLevel::findOrFail($id);

		// Hapus relasi di tabel pivot dulu agar tidak error (Integrity Constraint)
		$userlevel->menus()->detach();

		// Baru hapus data levelnya
		$userlevel->delete();

		return redirect()->route('userlevel.index')->with('success', 'Level berhasil dihapus');
	}	
	
 

 
}
