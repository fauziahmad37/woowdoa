<?php

namespace Database\Seeders;

use App\Models\Classes;
use App\Models\Merchant;
use App\Models\Schools;
use App\Models\Student;
use App\Models\TahunAjaran;
use App\Models\User;
use App\Models\UserLevel;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            SchoolSeeder::class,
            UserLevelSeeder::class,
            MerchantSeeder::class,
            UserSeeder::class,
            MenuSeeder::class,
            TahunAjaranSeeder::class,
            ClassesSeeder::class,
            ParentSeeder::class,
            StudentSeeder::class,
            TeacherSeeder::class,
        ]);
    }
}
