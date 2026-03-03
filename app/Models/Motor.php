<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Motor extends Model
{
    use HasFactory;

    protected $primaryKey = 'motor_id';

    protected $fillable = [
        'no_rangka',
        'no_mesin',
        'no_iot',
        'no_sim_card_iot',
        'no_controller_acu_motor',
        'no_plat',
        'jarak_tempuh',
        'no_baterai',
        'soc',
        'stnk_date',
        'assurance_name',
        'coverage_type',
       'periode_awal',  
    'periode_akhir', 
          'is_delete',
    'deleted_by',
    'updated_by',
    'created_by',
    ];

}
