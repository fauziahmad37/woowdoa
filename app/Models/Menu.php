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

    public function children()
    {
        return $this->hasMany(Menu::class, 'menu_parent', 'menu_id')
            ->orderBy('menu_sort');
    }

    protected $casts = [
    'menu_status' => 'boolean',
];

}
