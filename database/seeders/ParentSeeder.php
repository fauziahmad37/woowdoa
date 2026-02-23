<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Parents;
use Illuminate\Support\Facades\Hash;

class ParentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Parents::create([
            'parent_name' => 'Ahmad Fauzi',
            'parent_phone' => '081234567890',
            'address' => 'Jl. Merdeka No. 123, Jakarta',
            'active' => true,
            'user_id' => 4,
        ]);

    }
}
