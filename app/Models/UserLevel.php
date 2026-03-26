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
		return $this->belongsToMany(Menu::class, 'menu_level', 'menu_level_menu', 'menu_level_menu')
								->withTimestamps();
	}

	// Mendapatkan menu yang diizinkan untuk level ini
	public function allowedMenus()
	{
		return $this->belongsToMany(Menu::class, 'menu_level', 'menu_level_menu_id', 'menu_id')
								->withTimestamps();
	}
  

}
