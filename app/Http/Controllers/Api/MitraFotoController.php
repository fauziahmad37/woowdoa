<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Mitra;
use Illuminate\Support\Facades\Storage;

class MitraFotoController extends Controller
{

    public function update(Request $request)
    {
        // 1️⃣ Validasi input
        $request->validate([
            'mitra_id' => 'required|integer|exists:mitras,mitra_id',
            'foto_selfie' => 'required|file|image|max:2048', // max 2MB
        ]);

        // 2️⃣ Ambil mitra
        $mitra = Mitra::find($request->mitra_id);

        // 3️⃣ Simpan file selfie
        $file = $request->file('foto_selfie');
        $filename = uniqid() . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs('mitra/foto/mitra_foto_selfie', $filename, 'public');

        // 4️⃣ Update database
        $mitra->mitra_foto_selfie = $path;
        $mitra->save();

        // 5️⃣ Return JSON response
        return response()->json([
            'message' => 'Foto selfie berhasil diupdate',
            'mitra_id' => $mitra->mitra_id,
            'mitra_foto_selfie' => url('storage/' . $path),
        ]);
    }
}
