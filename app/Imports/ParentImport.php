<?php

namespace App\Imports;

use App\Models\User;
use App\Models\StudentParent;
use App\Models\School;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;

class ParentImport implements ToModel, WithHeadingRow, SkipsEmptyRows
{
    public function model(array $row)
    {

        if(empty($row['parent_name']) || empty($row['phone'])){
            return null;
        }

        // cari sekolah
        $school = School::where('school_name', $row['school'])->first();

        // normalisasi phone
        $phone = (string) $row['phone'];

        if(substr($phone,0,1) != '0'){
            $phone = '0'.$phone;
        }

        // buat user
        $user = User::create([
            'complete_name' => $row['parent_name'],
            'username' => $row['username'],
            'phone' => $phone,
            'email' => $row['email'] ?? null,
            'school_id' => $school?->id,
            'user_level_id' => 5,
            'password' => Hash::make('123456'),
            'is_active' => true
        ]);

        // simpan parent
        return new StudentParent([
            'parent_name' => $row['parent_name'],
            'parent_phone' => $phone,
            'school_id' => $school?->id,
            'address' => $row['address'] ?? null,
            'user_id' => $user->id,
            'active' => true
        ]);
    }
}