<?php

namespace App\Imports;

use App\Models\Santri;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Str;
class SantriImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {

     $username = Str::lower(str_replace(' ', '', $row['student_name']));

$user = User::create([
    'complete_name' => $row['student_name'],
    'username' => $row['nis'],
    'email' => $row['email'],
    'user_level_id' => 6,
    'password' => Hash::make('123456'),
    'is_active' => true
]);

        // lalu buat santri
        return new Santri([
            'nis' => $row['nis'],
            'student_name' => $row['student_name'],
            'gender' => $row['gender'],
            'phone' => $row['phone'],
            'user_id' => $user->id,
            'pin' => Hash::make('1234'),
        ]);
    }
}