<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CardRequest extends Model
{ 
	protected $fillable = [
			'nis',
			'status', 
			'reason',
			'school_id',
			'old_card_id',
			'requested_by',
			'approved_by',
			'approved_at'
	];

	public function student()
	{
			return $this->belongsTo(
					Student::class,'nis',
					'nis'
			);
	}

	public function requester()
	{
			return $this->belongsTo(
					User::class,
					'requested_by','username'
			);
	}

	public function oldCard()
	{
			return $this->belongsTo(
					Card::class,
					'old_card_id'
			);
	}
}
