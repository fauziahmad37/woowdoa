<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Classes;
use Illuminate\Support\Facades\Hash;

class ClassesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Classes::create([
            'class_name' => 'Kelas 4A',
            'class_level' => 4,
            'school_id' => 1,
        ]);

        Classes::create([
            'class_name' => 'Kelas 4B',
            'class_level' => 4,
            'school_id' => 1,
        ]);

    }
}
