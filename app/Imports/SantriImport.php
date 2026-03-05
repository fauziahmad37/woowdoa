<?php

namespace App\Imports;

use App\Models\Santri;
use App\Models\User;
use App\Models\Parents;
use App\Models\School;
use App\Models\Classes;
use App\Models\TahunAjaran;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;

class SantriImport implements ToModel, WithHeadingRow, SkipsEmptyRows
{
    public function model(array $row)
    {
    
        if(empty($row['nis']) || empty($row['student_name'])){
            return null;
        }

          $school = School::where('school_name', $row['school'])->first();
        // normalisasi phone santri
        $phone = (string) $row['phone'];

        if(substr($phone, 0, 1) != '0'){
            $phone = '0' . $phone;
        }

        // buat user
        $user = User::create([
            'complete_name' => $row['student_name'],
             'school_id' => $school?->id,
            'phone' => $phone,
            'username' => $row['nis'],
            'email' => $row['email'] ?? null,
            'user_level_id' => 6,
            'password' => Hash::make('123456'),
            'is_active' => true
        ]);

        // normalisasi parent phone
        $parentPhone = (string) $row['parent_phone'];

        if(substr($parentPhone, 0, 1) != '0'){
            $parentPhone = '0' . $parentPhone;
        }

        $parent = Parents::where('parent_phone', $parentPhone)->first();

        // cari school
        $school = School::where('school_name', $row['school'])->first();

        // cari class
        $class = Classes::where('class_name', $row['class'])->first();

        // cari tahun ajaran
        $tahunAjaran = TahunAjaran::where('tahun_ajaran', $row['tahun_ajaran'])->first();

        // generate VA
        $vaNumber = '100' . $row['nis'];

        return new Santri([
            'nis' => $row['nis'],
            'student_name' => $row['student_name'],
            'gender' => $row['gender'] ?? null,
            'phone' => $phone,
            'user_id' => $user->id,
            'pin' => Hash::make('1234'),
            'address' => $row['address'] ?? null,
            'email' => $row['email'] ?? null,
            'parent_id' => $parent?->id,
            'school_id' => $school?->id,
            'class_id' => $class?->id,
            'tahun_ajaran_id' => $tahunAjaran?->id,
            'va_number' => $vaNumber
        ]);
    }
}