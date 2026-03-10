<?php

namespace App\Services;

class CardService
{ 
	public function generateNumber($studentId)
	{
		$student = Student::findOrFail($studentId);
		$count = Card::where('student_id',$studentId)->count()+1;
		$urut = str_pad($count,3,'0',STR_PAD_LEFT);
		return $student->nis.'-'.$urut;
	}

}
