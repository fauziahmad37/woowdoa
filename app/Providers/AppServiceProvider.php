<?php
namespace App\Providers;
use Illuminate\Support\Facades\View;
use App\Models\Menu;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{

    public function boot()
    {
        View::composer('*', function ($view) {

            $user = Auth::user();

            if ($user) {

                // Ambil menu berdasarkan role user melalui tabel menu_level
                $menusRaw = DB::table('menus')
                    ->join('menu_level', 'menu_level.menu_level_menu', '=', 'menus.menu_id')
                    ->where('menu_level.menu_level_user_level', $user->user_level_id)
                    ->where('menus.menu_status', 1)
                    ->orderBy('menus.menu_parent')
                    ->orderBy('menus.menu_sort')
                    ->select('menus.*')
                    ->distinct()
                    ->get();

                // Membuat struktur parent-child menu
                $menus = [];

                foreach ($menusRaw as $menu) {
                    $menus[$menu->menu_parent][] = $menu;
                }

                // Kirim ke semua view
                $view->with('menus', $menus);
            }
        });
    }
}