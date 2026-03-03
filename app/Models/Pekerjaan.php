<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pekerjaan extends Model
{
    use HasFactory;

    protected $table = 'pekerjaans';
    protected $primaryKey = 'pekerjaan_id';
    public $timestamps = true; // kalau tabel pakai created_at & updated_at

    protected $fillable = [
        'pekerjaan_nama',
        'is_delete',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    /**
     * Supaya route model binding pakai primary key custom.
     */
    public function getRouteKeyName()
    {
        return 'pekerjaan_id';
    }
}
