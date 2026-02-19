<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LokasiKegiatan extends Model
{
    use HasFactory;


    protected $table = 'lokasi_kegiatan';

    protected $fillable = [
        'school_id',
        'name'
    ];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];

    public function jadwalKegiatan()
    {
        return $this->belongsTo(JadwalKegiatan::class, 'id', 'location_id');
    }
}
