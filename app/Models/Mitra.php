<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mitra extends Model
{
    use HasFactory;

    protected $table = 'mitras';
    protected $primaryKey = 'mitra_id';
    public $incrementing = true; // kalau pakai auto increment
    protected $keyType = 'int';

    protected $fillable = [
        'mitra_tanggal_lahir',
        'pekerjaan_id',
        'mitra_pendapatan_harian',
        'otp_expires_at',
        'mitra_alamat_domisili',
        'mitra_link_gmaps_rumah',
        'mitra_ibu_kandung',
        'mitra_no_hp',
        'mitra_email',
        'mitra_kontak_darurat',
        'mitra_nama_penjamin',
        'mitra_alamat_penjamin',
        'mitra_nik_penjamin',
        'mitra_no_hp_penjamin',
        'otp',
        'mitra_ktp',
        'mitra_kk',
        'mitra_sim',
        'mitra_foto_selfie',
        'mitra_foto_rumah',
        'mitra_ktp_penjamin',
        'mitra_bast_motor',
        'mitra_stnk',
        'mitra_dokumen_kontrak',
        'mitra_nama_lengkap',
        'mitra_tempat_lahir',
        'mitra_surat_perjanjian_penjamin',
        'mitra_jenis_kelamin',
        'mitra_nik',
        'mitra_no_kk',
        'mitra_id_provinsi',
        'mitra_id_kota',
        'mitra_id_kecamatan',
        'mitra_id_kelurahan',
        'created_by',
        'is_delete',
        'updated_by',
        'deleted_by',
        'mitra_latitude',
        'mitra_longitude',
        'mitra_lokasi',
        'is_pairing',
        'mitra_telfon_kontak_darurat',
        'mitra_ayah_kandung',
        'mitra_jenis',
        'mitra_status',
    ];

    /** 🔗 Relasi ke tabel pekerjaan */
    public function pekerjaan()
    {
        return $this->belongsTo(Pekerjaan::class, 'pekerjaan_id');
    }

    /** 📍 Accessor lokasi gabungan */
    public function getMitraLokasiAttribute()
    {
        if ($this->mitra_latitude && $this->mitra_longitude) {
            return $this->mitra_latitude . ', ' . $this->mitra_longitude;
        }
        return null;
    }

    /** ⚙️ Event ketika mitra diupdate */
   protected static function booted()
{
    static::updated(function ($mitra) {
        // pakai primary key yang benar: mitra_id
        if ($mitra->isDirty('is_delete') && $mitra->is_delete === true) {

            \App\Models\Pembayaran::where('mitra_id', $mitra->mitra_id)
                ->update(['is_delete' => true]);

            \App\Models\SerahTerima::where('mitra_id', $mitra->mitra_id)
                ->update(['is_delete' => true]);

            // 🔥 Tambahan untuk model Sos (kolomnya 'mitras_id')
            \App\Models\Sos::where('mitras_id', $mitra->mitra_id)
                ->update(['is_delete' => true]);
        }
    });
}

}
