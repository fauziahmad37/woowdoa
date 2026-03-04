<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Teacher;
use Illuminate\Support\Facades\Hash;

class TeacherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Teacher::create([
            'teacher_name' => 'Abdul Razak',
            'nik' => '1234567890123',
            'email' => 'abdul.razak@gmail.com',
            'phone' => '081234567890',
            'address' => 'Jl. Merdeka No. 123, Jakarta',
            'active' => true,
            'user_id' => 5,
            'school_id' => 1,
        ]);

    }
}
