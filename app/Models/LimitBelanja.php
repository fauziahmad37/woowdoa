<?php

namespace App\Models; 

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class LimitBelanja extends Model
{
	use HasFactory; 
	protected $fillable = [
			'school_id',
			'class_level',
			'daily_limit',
			'monthly_limit'
	];
	
	protected static function booted()
	{
		static::creating(function ($model) { 
				$model->school_id = Auth::user()->school_id;
		});
	}		
}
