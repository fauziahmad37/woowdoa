<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\School;
use Illuminate\Support\Facades\Hash;

class SchoolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        School::create([
            'school_name' => 'Sekolah Dasar Negeri 1',
            'npsn' => '12345678',
            'address' => 'Jl. Merdeka No. 123, Jakarta',
            'phone' => '081234567890',
            'email' => 'info@sdn1jakarta.sch.id',
            'logo' => 'sdn1_logo.png',
            'is_active' => true,
        ]);
    }
}
