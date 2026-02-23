<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Student;
use Illuminate\Support\Facades\Hash;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Student::create([
            'nis' => '19931121',
            'student_name' => 'Ahmad Fauzi',
            'gender' => 'Laki-laki',
            'address' => 'Jl. Merdeka No. 123, Jakarta',
            'phone' => '081234567890',
            'email' => 'fauzi.enginer@gmail.com',
            'tahun_ajaran_id' => 2,
            'class_id' => 1,
            'school_id' => 1,
            'parent_id' => 1,
            'saldo' => 100000,
            'pin' => Hash::make('1234'),
            'user_id' => 2,
            'class_id' => 1,
            'school_id' => 1,
            'parent_id' => 1,
        ]);

    }
}
