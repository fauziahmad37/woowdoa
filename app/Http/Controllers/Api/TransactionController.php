<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseApiController;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Student;
use App\Models\Notification;
use App\Models\Transaction;
use App\Services\FirebaseService;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;



class TransactionController extends BaseApiController
{

    /**
     * GET List Transaksi
     */
    public function index(Request $request)
    {
        $query = Transaction::query()
            ->with('student:id,student_name,nis');

        // Filter berdasarkan NIS (optional)
        if ($request->filled('nis')) {
            $query->whereHas('student', function ($q) use ($request) {
                $q->where('nis', $request->nis);
            });
        }

        // Filter start date
        if ($request->filled('start_date')) {
            $query->whereDate('transaction_date', '>=', $request->start_date);
        }

        // Filter end date
        if ($request->filled('end_date')) {
            $query->whereDate('transaction_date', '<=', $request->end_date);
        }

        // 🔹 Clone query untuk hitung total
        $totalAmount = (clone $query)->sum('amount');

        // perpage
        $perPage = $request->input('per_page', 10);

        $transactions = $query
            ->orderBy('transaction_date', 'desc')
            ->paginate($perPage);

       return $this->successPaginate($transactions, 'List transaksi retrieved successfully', [
            'total_amount' => $totalAmount
        ]);
    }

    /**
     * GET Data User From NIS
     */
    public function scan(Request $request)
    {
        $nis = trim($request->input('nis'));

        $santri = Student::select('id', 'student_name', 'nis', 'saldo')
            ->where('nis', $nis)
            ->first();

        if (!$santri) {
            return $this->error('Santri tidak ditemukan', 404);
        }



        return $this->success($santri, 'Data santri retrieved successfully');
    }

    /**
     * POST Pembayaran
     */
    public function pay(Request $request)
    {
        $request->validate([
            'nis' => 'required',
            'amount' => 'required|numeric|min:1000',
            'pin' => 'required'
        ]);

        DB::beginTransaction();

        try {

            $santri = Student::where('nis', $request->nis)->lockForUpdate()->first();

            if (!$santri) {
                return $this->error('Santri tidak ditemukan', 404);
            }

            // cek PIN
            if (!Hash::check($request->pin, $santri->pin)) {
                return $this->error('PIN salah', 401);
            }

            // cek saldo
            if ($santri->saldo < $request->amount) {
                return $this->error('Saldo tidak cukup', 400);
            }

            $saldoBefore = $santri->saldo;
            $saldoAfter  = $saldoBefore - $request->amount;

            // potong saldo
            $santri->update([
                'saldo' => $saldoAfter
            ]);

            // buat kode transaksi
            $transactionCode = 'TRX-' . Str::upper(Str::random(10));

            $transaction = Transaction::create([
                'transaction_code' => $transactionCode,
                'student_id' => $santri->id,
                'amount' => $request->amount,
                'saldo_before' => $saldoBefore,
                'saldo_after' => $saldoAfter,
                'transaction_date' => now(),
            ]);

            // Insert ke table notifikasi
            Notification::create([
                'title' => 'Pembayaran Berhasil',
                'body' => "Pembayaran sebesar Rp {$request->amount} berhasil. Sisa saldo Anda sekarang Rp {$saldoAfter}.",
                'is_read' => false,
                'user_id' => $santri->user_id,
                'type' => 'transaksi',
                'data' => [
                    'transaction_id' => $transaction->id,
                    'transaction_code' => $transactionCode,
                    'amount' => $request->amount,
                    'saldo_before' => $saldoBefore,
                    'saldo_after' => $saldoAfter,
                    'transaction_date' => now()->format('Y-m-d H:i:s'),
                ]
            ]);

            DB::commit();

            // Push notifikasi menggunakan Firebase Cloud Messaging
            $firebase = new FirebaseService();

            $device_token = $santri->user->device_token;

            $firebase->sendNotification(
                $device_token,
                "Pembayaran Berhasil",
                "Pembayaran sebesar Rp {$request->amount} berhasil. Sisa saldo Anda sekarang Rp {$saldoAfter}."
            );


            return $this->success([
                'transaction_id' => $transaction->id,
                'transaction_code' => $transaction->transaction_code,
                'tanggal' => $transaction->transaction_date->format('d-m-Y, H:i'),
                'total_pembayaran' => $transaction->amount,
                'nama' => $santri->student_name,
                'nis' => $santri->nis,
                'sisa_saldo' => $saldoAfter
            ], 'Pembayaran berhasil');
        } catch (\Exception $e) {

            DB::rollBack();

            return $this->error('Terjadi kesalahan', 500, $e->getMessage());
        }
    }

    /**
     * GET Detail Transaksi By Kode Transaksi
     */
    public function showByCode($code)
    {
        $transaction = Transaction::with('student:id,student_name,nis,saldo')
            ->where('transaction_code', $code)
            ->first();

        if (!$transaction) {
            return $this->error('Transaksi tidak ditemukan', 404);
        }

        return $this->success([
            'transaction_code' => $transaction->transaction_code,
            'tanggal' => $transaction->transaction_date->format('d-m-Y H:i'),
            'nama' => $transaction->student->student_name,
            'nis' => $transaction->student->nis,
            'total_pembayaran' => $transaction->amount,
            'saldo_sebelum' => $transaction->saldo_before,
            'saldo_sesudah' => $transaction->saldo_after,
            'saldo_terakhir_santri' => $transaction->student->saldo
        ]);
    }
}
