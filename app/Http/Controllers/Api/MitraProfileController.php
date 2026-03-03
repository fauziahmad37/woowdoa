<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Mitra;
use Illuminate\Support\Facades\DB;

class MitraProfileController extends Controller
{
    /**
     * Tampilkan profil Mitra berdasarkan mitra_id (tanpa token)
     */
    public function show(Request $request)
    {
        // 1️⃣ Ambil mitra_id dari request
        $mitraId = $request->input('mitra_id');

        if (!$mitraId) {
            return response()->json(['message' => 'mitra_id wajib dikirim'], 400);
        }

        // 2️⃣ Ambil data Mitra
        $mitra = Mitra::find($mitraId);
        if (!$mitra) {
            return response()->json(['message' => 'Mitra tidak ditemukan'], 404);
        }

        // 3️⃣ Ambil nama pekerjaan
        $pekerjaan = $mitra->pekerjaan_id
            ? DB::table('pekerjaans')
                ->where('pekerjaan_id', $mitra->pekerjaan_id)
                ->value('pekerjaan_nama')
            : null;

        // 4️⃣ Return data JSON
        return response()->json([
            'mitra_id' => $mitra->mitra_id,
            'mitra_nama_lengkap' => $mitra->mitra_nama_lengkap,
            'pekerjaan_nama' => $pekerjaan,
            'mitra_no_hp' => $mitra->mitra_no_hp,
            'mitra_email' => $mitra->mitra_email,
            'mitra_tempat_lahir' => $mitra->mitra_tempat_lahir,
            'mitra_tanggal_lahir' => $mitra->mitra_tanggal_lahir,
            'mitra_alamat_domisili' => $mitra->mitra_alamat_domisili,
            'mitra_foto_selfie' => $mitra->mitra_foto_selfie
                ? url('storage/' . $mitra->mitra_foto_selfie)
                : null,
        ]);
    }
}
