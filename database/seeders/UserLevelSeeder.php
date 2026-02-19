<?php

namespace Database\Seeders;

use App\Models\UserLevel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserLevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        UserLevel::create([
            'user_level_id' => '1',
            'user_level_name' => 'Admin',
        ]);

        UserLevel::create([
            'user_level_id' => '2',
            'user_level_name' => 'Merchant',
        ]);

        UserLevel::create([
            'user_level_id' => '3',
            'user_level_name' => 'Store',
        ]);
    }
}
