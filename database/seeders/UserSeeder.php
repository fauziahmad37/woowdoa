<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'complete_name' => 'Admin User',
            'username' => 'admin',
            'email' => 'admin@admin.com',
            'password' => bcrypt('123456'),
            'user_level_id' => '1',
            'last_login' => now(),
            'is_active' => true,
            'phone' => '081234567890',
        ]);

        User::create([
            'complete_name' => 'Ahmad Fauzi',
            'username' => 'fauzi',
            'email' => 'fauzi.enginer@gmail.com',
            'password' => bcrypt('123456'),
            'user_level_id' => '2',
            'last_login' => now(),
            'is_active' => true,
            'phone' => '081234567890',
        ]);

        User::create([
            'complete_name' => 'Fauzan Tamsin',
            'username' => 'fauzan',
            'email' => 'fauzantamsin09@gmail.com',
            'password' => bcrypt('123456'),
            'user_level_id' => 2,
            'last_login' => now(),
            'is_active' => true,
            'phone' => '081234567890',
        ]);

    }
}
