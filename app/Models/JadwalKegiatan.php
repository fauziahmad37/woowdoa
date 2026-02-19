<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalKegiatan extends Model
{
    use HasFactory;


    protected $table = 'jadwal_kegiatan';

    protected $fillable = [
        'school_id',
        'class_id',
        'day',
        'start_time',
        'end_time',
        'activity_name',
        'teacher_id',
        'location_id',
    ];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];

    public function locationKegiatan()
    {
        return $this->hasOne(LokasiKegiatan::class, 'id', 'location_id');
    }
}
