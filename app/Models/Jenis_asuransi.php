<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jenis_asuransi extends Model
{
    use HasFactory;

    protected $table = 'jenis_asuransi';
    protected $primaryKey = 'jenis_asuransi_id';
    public $timestamps = true;

    protected $fillable = [
        'jenis_asuransi_nama',
        'is_delete',
        'created_by',
        'updated_by',
        'deleted_by',
    ];
}
