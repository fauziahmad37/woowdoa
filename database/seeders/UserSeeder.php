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
            'user_level_id' => 1,
            'last_login' => now(),
            'is_active' => true,
            'phone' => '081234567890',
            'school_id' => 1,
        ]);

        User::create([
            'complete_name' => 'Tamsin',
            'username' => 'tamsin',
            'email' => 'tamsin@gmail.com',
            'password' => bcrypt('123456'),
            'user_level_id' => 5,
            'last_login' => now(),
            'is_active' => true,
            'phone' => '081234567890',
            'school_id' => 1,
            'device_token' => 'f6XzQ0gmQKmv0o6PlEOwNC:APA91bGsO2o0WcYDvse4Nd4L7_IccXGtyWEB6wbQHi_mB-92Af5VvaQrvZd4WmBaeuWV0iocJTx1UTXBvD5LfCPV62w3eBoXVK_LTrnTTBsf0e29ey5V_Vg',
        ]);

        User::create([
            'complete_name' => 'Ahmad Fauzi',
            'username' => 'fauzi',
            'email' => 'fauzi.enginer@gmail.com',
            'password' => bcrypt('123456'),
            'user_level_id' => 3,
            'last_login' => now(),
            'is_active' => true,
            'phone' => '081234567890',
            'school_id' => 1,
        ]);

        User::create([
            'complete_name' => 'Fauzan Tamsin',
            'username' => 'fauzan',
            'email' => 'fauzantamsin09@gmail.com',
            'password' => bcrypt('123456'),
            'user_level_id' => 4,
            'last_login' => now(),
            'is_active' => true,
            'phone' => '081234567890',
            'school_id' => 1,
        ]);

        User::create([
            'complete_name' => 'Sukma',
            'username' => 'sukma',
            'email' => 'sukma@gmail.com',
            'password' => bcrypt('123456'),
            'user_level_id' => 4,
            'last_login' => now(),
            'is_active' => true,
            'phone' => '081234567890',
            'school_id' => 1,
        ]);

        User::create([
            'complete_name' => 'Panji',
            'username' => 'panji',
            'email' => 'panji@gmail.com',
            'password' => bcrypt('123456'),
            'user_level_id' => 4,
            'last_login' => now(),
            'is_active' => true,
            'phone' => '081234567890',
            'school_id' => 1,
        ]);

        User::create([
            'complete_name' => 'Abdul Razak',
            'username' => 'abdul.razak',
            'email' => 'abdul.razak@gmail.com',
            'password' => bcrypt('123456'),
            'user_level_id' => 5,
            'last_login' => now(),
            'is_active' => true,
            'phone' => '081234567890',
            'school_id' => 1,
            'profile_photo' => '/storage/users/teacher1.jpg',
        ]);

        User::create([
            'complete_name' => 'Ibu Siti',
            'username' => 'ibu.siti',
            'email' => 'kantin.ibusiti@gmail.com',
            'password' => bcrypt('123456'),
            'user_level_id' => 2,
            'last_login' => now(),
            'is_active' => true,
            'phone' => '081234567890',
            'school_id' => 1,
            'profile_photo' => '/storage/users/teacher2.jpg',
            'merchant_id' => 1,
        ]);

        User::create([
            'complete_name' => 'Pak Budi',
            'username' => 'pak.budi',
            'email' => 'pak.budi@gmail.com',
            'password' => bcrypt('123456'),
            'user_level_id' => 2,
            'last_login' => now(),
            'is_active' => true,
            'phone' => '081234567891',
            'school_id' => 1,
            'profile_photo' => '/storage/users/teacher3.jpg',
            'merchant_id' => 2,
        ]);
    }
}
