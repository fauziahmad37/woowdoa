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
            'student_name' => 'Fauzan Tamsin',
            'gender' => 'Laki-laki',
            'address' => 'Jl. Merdeka No. 123, Jakarta',
            'phone' => '081234567890',
            'email' => 'fauzantamsin09@gmail.com',
            'tahun_ajaran_id' => 2,
            'class_id' => 1,
            'school_id' => 1,
            'parent_id' => 1,
            'saldo' => 100000,
            'pin' => Hash::make('1234'),
            'user_id' => 3,
            'class_id' => 1,
            'school_id' => 1,
            'parent_id' => 1,
        ]);

        Student::create([
            'nis' => '19931122',
            'student_name' => 'Sukma',
            'gender' => 'Perempuan',
            'address' => 'Jl. Merdeka No. 124, Jakarta',
            'phone' => '081234567891',
            'email' => 'sukma@gmail.com',
            'tahun_ajaran_id' => 2,
            'class_id' => 1,
            'school_id' => 1,
            'parent_id' => 1,
            'saldo' => 150000,
            'pin' => Hash::make('1234'),
            'user_id' => 4,
            'class_id' => 1,
            'school_id' => 1,
            'parent_id' => 1,
        ]);

        Student::create([
            'nis' => '19931123',
            'student_name' => 'Panji',
            'gender' => 'Laki-laki',
            'address' => 'Jl. Merdeka No. 125, Jakarta',
            'phone' => '081234567892',
            'email' => 'panji@gmail.com',
            'tahun_ajaran_id' => 2,
            'class_id' => 1,
            'school_id' => 1,
            'parent_id' => 1,
            'saldo' => 200000,
            'pin' => Hash::make('1234'),
            'user_id' => 5,
            'class_id' => 1,
            'school_id' => 1,
            'parent_id' => 1,
        ]);
    }
}
