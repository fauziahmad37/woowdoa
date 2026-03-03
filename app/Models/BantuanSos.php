<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BantuanSos extends Model
{
    use HasFactory;

    protected $table = 'bantuan_sos';

    protected $fillable = [
        'sos_nama_mitra',
        'sos_nomor_iot_motor',
        'sos_lokasi',
        'sos_nama_teknisi',
        'sos_phone',
        'mitra_id',
        'sos_status',
    ];

    // Relasi ke mitra
    public function mitra()
    {
        return $this->belongsTo(Mitra::class, 'mitra_id', 'mitra_id');
    }

    // Relasi ke teknisi (opsional, jika teknisi nanti ada tabel teknisi)
    public function teknisi()
    {
        return $this->belongsTo(Teknisi::class, 'sos_nama_teknisi', 'teknisi_nama');
    }
}
