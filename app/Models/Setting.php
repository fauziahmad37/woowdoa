<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $table = 'settings';
    protected $fillable = [
        'app_name',
        'site_title',
        'home_title',
        'site_desk',
        'keywords',
        'description',
        'about_footer',
        'copyright',
        'logo_light',
        'logo_dark',
        'logo_mini',
    ];}
