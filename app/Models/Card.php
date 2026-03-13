<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
	protected $fillable = [
			'nis',
			'card_number',
			'sequence',
			'status',
			'reason',
			'print_count'
	];

	public function student()
	{
		return $this->belongsTo(
				Student::class,'nis',
				'nis'
		);
	}
	public function user()
	{
		return $this->belongsTo(
				User::class,'nis','username'

		);
	}

    public function nis()
    {
        return $this->belongsTo(Student::class, 'nis', 'nis');
    }
}
