<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseApiController;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Student;
use App\Models\Notification;
use App\Models\Parents;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Services\FirebaseService;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Mockery\Matcher\Not;

class TransactionController extends BaseApiController
{

    /**
     * GET List Transaksi
     */
    public function index(Request $request)
    {
        $query = Transaction::query()
            ->join('students', 'transactions.student_id', '=', 'students.id')
            ->select(
                'transactions.*',
                'students.student_name',
                'students.nis'
            );

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

        // Filter berdasarkan merchant_id dari user yang login
        $user = auth()->user();
        if ($user->user_level_id == '2') { // Jika user adalah merchant
            $query->where('merchant_id', $user->merchant_id);
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

        // JIKA USER LOGIN DENGAN ROLE SELAIN MERCHANT ATAU 2, MAKA TIDAK BOLEH MENGAKSES ENDPOINT INI
        $user = auth()->user();
        if (!in_array($user->user_level_id, ['2'])) {
            return $this->error('Hanya merchant yang dapat mengakses endpoint ini', 403);
        }

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
            'pin' => 'required',
        ]);

        // JIKA USER LOGIN DENGAN ROLE SELAIN MERCHANT ATAU 2, MAKA TIDAK BOLEH MENGAKSES ENDPOINT INI
        $user = auth()->user();
        if (!in_array($user->user_level_id, ['2'])) {
            return $this->error('Unauthorized', 403);
        }

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

            // buat kode transaksi
            $transactionCode = 'TRX-' . Str::upper(Str::random(10));

            $transaction = Transaction::create([
                'merchant_id' => $user->merchant_id,
                'student_id' => $santri->id,
                'transaction_code' => $transactionCode,
                'virtual_account_number' => $santri->va_number,
                'total_amount' => $request->amount,
                'paid_amount' => $request->amount,
                'status' => 'paid',
                'paid_at' => now(),
            ]);

            $transactionDetail = TransactionDetail::create([
                'transaction_id' => $transaction->id,
                'type' => 'credit',
                'amount' => $request->amount,
                'saldo_before' => $saldoBefore,
                'saldo_after' => $saldoAfter,
                'description' => 'Pembayaran di merchant ' . $user->merchant->merchant_name,
            ]);


            $dataInsert = [
                'title' => 'Pembayaran Berhasil',
                'body' => "Pembayaran sebesar Rp {$request->amount} berhasil. Sisa saldo Anda sekarang Rp {$saldoAfter}.",
                'is_read' => false,
                'user_id' => $user->id, // Notifikasi untuk merchant
                'type' => 'transaksi',
                'data' => [
                    'transaction_id' => $transaction->id,
                    'transaction_code' => $transactionCode,
                    'amount' => $request->amount,
                    'saldo_before' => $saldoBefore,
                    'saldo_after' => $saldoAfter,
                    'transaction_date' => now()->format('Y-m-d H:i:s'),
                ]
            ];

            // potong saldo
            $santri->update([
                'saldo' => $saldoAfter
            ]);

            // Insert ke table notifikasi untuk merchant
            Notification::create($dataInsert);
            // Insert ke table notifikasi untuk santri
            $dataInsert['user_id'] = $santri->user_id;
            Notification::create($dataInsert);
            // Insert ke table notifikasi untuk wali santri (jika ada)
            $dataInsert['user_id'] = Parents::where('id', $santri->parent_id)->value('user_id');
            Notification::create($dataInsert);

            DB::commit();

            // Push notifikasi menggunakan Firebase Cloud Messaging
            $firebase = new FirebaseService();

            $deviceTokens = [];
            $deviceTokens[] = $user->device_token; // Notifikasi untuk merchant
            $deviceTokens[] = $santri->user->device_token; // Notifikasi untuk santri
            $userIdParent = Parents::where('id', $santri->parent_id)->value('user_id'); // Notifikasi untuk wali santri (jika ada)
            $deviceTokens[] = User::where('id', $userIdParent)->value('device_token');

            foreach ($deviceTokens as $token) {
                if ($token) {
                    $firebase->sendNotification(
                        $token,
                        "Pembayaran Berhasil",
                        "Pembayaran sebesar Rp {$request->amount} berhasil. Sisa saldo Anda sekarang Rp {$saldoAfter}."
                    );
                }
            }

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
