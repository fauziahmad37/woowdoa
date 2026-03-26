<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $table = 'menus';
    protected $primaryKey = 'menu_id';

    protected $fillable = [
        'menu_name', 'menu_link', 'menu_parent', 'role_id',
        'menu_group', 'menu_sort', 'menu_status',
        'menu_icon', 'menu_type', 'menu_label'
    ];

    // Mendapatkan menu parent
    public function parent()
    {
        return $this->belongsTo(Menu::class, 'menu_parent', 'menu_id');
    }


    public function children()
    {
        return $this->hasMany(Menu::class, 'menu_parent', 'menu_id')
            ->orderBy('menu_sort');
    }

    // Mendapatkan semua menu dalam bentuk tree
    public static function getMenuTree($levelId = null)
    {
        $query = self::where('menu_parent', 0)->orderBy('menu_id');
        
        $menus = $query->get();
        
        foreach ($menus as $menu) {
            $menu->children = self::getChildren($menu->menu_id, $levelId);
        }
        
        return $menus;
    }

		// Mendapatkan child menu dengan pengecekan akses level
    protected static function getChildren($parentId, $levelId = null)
    {
        $query = self::where('menu_parent', $parentId)->orderBy('menu_id');
        
        if ($levelId) {
            $query->whereHas('levels', function($q) use ($levelId) {
                $q->where('menu_level_id', $levelId);
            });
        }
        
        $children = $query->get();
        
        foreach ($children as $child) {
            $child->children = self::getChildren($child->menu_id, $levelId);
        }
        
        return $children;
    }
		

    protected $casts = [
    'menu_status' => 'boolean',
];

}
