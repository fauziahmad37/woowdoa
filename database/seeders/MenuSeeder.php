<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $menus = [
            [
                'menu_id' => 1,
                'menu_name' => 'Dashboard',
                'menu_link' => 'dashboard',
                'menu_parent' => 0,
                'menu_group' => 1,
                'menu_status' => 1,
                'menu_icon' => 'bx bx-home-circle',
            ],
            [
                'menu_id' => 2,
                'menu_name' => 'Akses Level',
                'menu_link' => 'settings/menu',
                'menu_parent' => 0,
                'menu_group' => 0,
                'menu_status' => 1,
                'menu_icon' => 'bx bx-directions'
            ]
        ];

        // Opsi B: Loop dengan updateOrInsert (Lebih aman untuk development)
        foreach ($menus as $menu) {
            DB::table('menu')->updateOrInsert(
                ['menu_id' => $menu['menu_id']], // Cek berdasarkan ID
                $menu // Update atau Insert data ini
            );
        }

        $menuLevels = [
            [
                'menu_level_id' => 1,
                'menu_level_user_level' => 1, // Admin
                'menu_level_menu' => 1, // Dashboard
            ],
            [
                'menu_level_id' => 2,
                'menu_level_user_level' => 1, // Admin
                'menu_level_menu' => 2, // Akses Level
            ],
            [
                'menu_level_id' => 3,
                'menu_level_user_level' => 2, // User
                'menu_level_menu' => 1, // Dashboard
            ],
        ];

        foreach ($menuLevels as $menuLevel) {
            DB::table('menu_level')->updateOrInsert(
                ['menu_level_id' => $menuLevel['menu_level_id']], // Cek berdasarkan ID
                $menuLevel // Update atau Insert data ini
            );
        }
    }
}
