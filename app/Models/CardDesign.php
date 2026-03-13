<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CardDesign extends Model
{ 
	
	protected $fillable = [
			'name',
			'front_background',
			'back_background',
			'width',
			'height',
			'front_elements',
			'back_elements',
			'school_id'
	];

	public function student()
	{
			return $this->belongsTo(Student::class);
	}
}