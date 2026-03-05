<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BankController extends Controller
{
    public function callback(Request $request)
    {
        \Log::info('Callback dari bank', $request->all());

        return response()->json([
            'status' => 'success',
            'message' => 'Pembayaran diterima'
        ]);
    }
}
