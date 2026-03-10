<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CardDesign extends Model
{ 
	
	protected $fillable = [
			'name',
			'background_image',
			'width',
			'height',
			'elements'
	];

	public function student()
	{
			return $this->belongsTo(Student::class);
	}
}