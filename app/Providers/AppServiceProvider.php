<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use App\Models\Menu;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        View::composer('*', function ($view) {
            $user = Auth::user();

            // ➤ Test role_id dulu
            if ($user) {

                $menusRaw = Menu::where('role_id', $user->user_level_id)
                    ->where('menu_status', true)
                    ->orderBy('menu_sort')
                    ->get();
                // dd($user->user_level_id);
                // dd(Menu::select('menu_id','menu_name','menu_parent')->get()->toArray());
                // // Buat tree
                $menus = [];

                foreach ($menusRaw as $m) {
                    $menus[$m->menu_parent][] = $m;
                }

                $view->with('menus', $menus);
            }
        });
    }
}
