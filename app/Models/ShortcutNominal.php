<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class ShortcutNominal extends Model
{
	use HasFactory; 
	protected $fillable = [
			'school_id',
			'nominal1',
			'nominal2',
			'nominal3',
			'nominal4',
			'nominal5',
			'nominal6' 
	];
}
