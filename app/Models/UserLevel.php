<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserLevel extends Model
{
	use HasFactory;
	protected $table = 'user_levels';
	protected $primaryKey = 'user_level_id'; 
	
	protected $fillable = [
		'user_level_id',
		'user_level_name',
	];


	// Relasi ke tabel menu melalui menu_level
	public function menus()
	{
		//return $this->belongsToMany(Menu::class, 'menu_level', 'menu_level_menu', 'menu_level_menu')
		//					->withTimestamps();
	
    return $this->belongsToMany(
        Menu::class, 
        'menu_level',             // Nama tabel pivot
        'menu_level_user_level',  // Foreign key milik UserLevel
        'menu_level_menu',        // Foreign key milik Menu
        'user_level_id',          // Local key di tabel user_levels
        'menu_id'                 // Local key di tabel menus
    )->withPivot('menu_level_id'); // Jika ingin mengambil primary key pivotnya
	}
	
	// Mendapatkan menu yang diizinkan untuk level ini
	public function allowedMenus()
	{
		return $this->belongsToMany(Menu::class, 'menu_level', 'menu_level_menu_id', 'menu_id')
								->withTimestamps();
	}
  

}
