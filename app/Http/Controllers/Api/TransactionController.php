<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseApiController;
use App\Models\Classes;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Student;
use App\Models\Notification;
use App\Models\Parents;
use App\Models\Ewallet;
use App\Models\Settlement;
use App\Models\WalletMovement;
use App\Models\Transaction;
use App\Models\LimitBelanja;
use App\Models\TransactionDetail;
use App\Services\FirebaseService;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Mockery\Matcher\Not;
use Illuminate\Support\Facades\Http;

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
            $query->whereDate('paid_at', '>=', $request->start_date);
        }

        // Filter end date
        if ($request->filled('end_date')) {
            $query->whereDate('paid_at', '<=', $request->end_date);
        }

        // Filter berdasarkan merchant_id dari user yang login
        $user = auth()->user();
        if (in_array($user->user_level_id, ['2', '3'])) { // Jika user adalah merchant
            $query->where('merchant_id', $user->merchant_id);
            $query->leftJoin('students as s', 'transactions.student_id', '=', 's.id');
            $query->leftJoin('classes as c', 's.class_id', '=', 'c.id');
            $query->select('transactions.*', 's.student_name', 's.nis', 's.class_id', 'c.class_level', 'c.class_name');
        }

        if (in_array($user->user_level_id, ['5'])) { // jika user adalah ortu
            $parent = Parents::where('user_id', $user->id)->first();
            $studentIds = Student::where('parent_id', $parent->id)->pluck('id');

            $query->whereHas('student', function ($q) use ($studentIds) {
                $q->whereIn('id', $studentIds);
            });
            $query->leftJoin('students as s', 'transactions.student_id', '=', 's.id');
            $query->leftJoin('classes as c', 's.class_id', '=', 'c.id');
            $query->leftJoin('payment_types as pt', 'transactions.payment_type_id', '=', 'pt.id');
            $query->select('transactions.*', 's.student_name', 's.nis', 's.class_id', 'c.class_level', 'c.class_name', 'pt.payment_name');
        }

        // 🔹 Clone query untuk hitung total
        $totalAmount = (clone $query)->sum('total_amount');

        // perpage
        $perPage = $request->input('per_page', 10);

        $transactions = $query
            ->orderBy('id', 'desc')
            ->paginate($perPage);

        return $this->successPaginate($transactions, 'List transaksi retrieved successfully', [
            'total_amount' => $totalAmount
        ]);
    }

    /**
     * GET Data User From Card Number
     */
    public function scan(Request $request)
    {
        $cardNumber = trim($request->input('card_number'));

        // JIKA USER LOGIN DENGAN ROLE SELAIN MERCHANT ATAU 2, MAKA TIDAK BOLEH MENGAKSES ENDPOINT INI
        $user = auth()->user();
        if (!in_array($user->user_level_id, ['2', '3'])) {
            return $this->error('Hanya merchant yang dapat mengakses endpoint ini', 403);
        }

        $santri = Student::select('students.id', 'students.student_name', 'students.nis', 'students.user_id')
            ->leftJoin('cards as c', 'students.nis', '=', 'c.nis')
            ->where('c.card_number', $cardNumber)
            ->first();

        // Validasi jika santri tidak ditemukan
        if (!$santri) {
            return $this->error('Santri tidak ditemukan', 404);
        }

        $ewallet = Ewallet::where('user_id', $santri->user_id)->first();
        $santri->saldo = $ewallet ? $ewallet->balance : 0;

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
            'card_number' => 'required',
            'amount' => 'required|numeric|min:1000',
            'pin' => 'required',
        ]);

        // JIKA USER LOGIN DENGAN ROLE SELAIN MERCHANT ATAU 2, MAKA TIDAK BOLEH MENGAKSES ENDPOINT INI
        $user = auth()->user();
        if (!in_array($user->user_level_id, ['2', '3'])) {
            return $this->error('Unauthorized', 403);
        }

        DB::beginTransaction();

        try {
            $santri = Student::select('students.id', 'students.student_name', 'students.nis', 'students.user_id', 'students.pin', 'students.class_id', 'students.school_id', 'students.va_number', 'students.parent_id')
                ->leftJoin('cards as c', 'students.nis', '=', 'c.nis')
                ->where('c.card_number', $request->card_number)
                ->first();

            // cek santri
            if (!$santri) {
                return $this->error('Santri tidak ditemukan', 404);
            }

            // cek PIN
            if (!Hash::check($request->pin, $santri->pin)) {
                return $this->error('PIN salah', 401);
            }

            // cek limit pembayaran harian
            $totalPaidToday = Transaction::where('student_id', $santri->id)
                ->whereDate('paid_at', now()->toDateString())
                ->sum('paid_amount');

            $santriClass = Classes::where('id', $santri->class_id)->first();
            $dailyLimit = LimitBelanja::where('school_id', $santri->school_id)
                ->where('class_level', $santriClass->class_level)
                ->first();

            // Jika ada limit harian, cek apakah total pembayaran hari ini + jumlah pembayaran melebihi limit
            if ($dailyLimit && ($totalPaidToday + $request->amount) > $dailyLimit->daily_limit) {
                return $this->error('Pembayaran melebihi limit harian', 400);
            }

            // cek limit pembayaran bulanan
            $totalPaidThisMonth = Transaction::where('student_id', $santri->id)
                ->whereYear('paid_at', now()->year)
                ->whereMonth('paid_at', now()->month)
                ->sum('paid_amount');
            if ($dailyLimit && ($totalPaidThisMonth + $request->amount) > $dailyLimit->monthly_limit) {
                return $this->error('Pembayaran melebihi limit bulanan', 400);
            }



            // =================== cek saldo ===================
            // GET Wallet Santri
            $ewallet = Ewallet::where('user_id', $santri->user_id)->first();
            if (!$ewallet || $ewallet->balance < $request->amount) {
                return $this->error('Saldo tidak cukup', 403);
            }

            $saldoBefore = $ewallet->balance;
            $saldoAfter  = $saldoBefore - $request->amount;

            // SIMPAN TRANSAKSI
            $transactionCode = $this->generateTransactionCode();
            $transaction = Transaction::create([
                'merchant_id' => $user->merchant_id,
                'student_id' => $santri->id,
                'transaction_code' => $transactionCode,
                'virtual_account_number' => $santri->va_number,
                'total_amount' => $request->amount,
                'paid_amount' => $request->amount,
                'status' => 'pending',
                'payment_type_id' => 1, // Tambahkan ini untuk menyimpan tipe pembayaran
                'card_number' => $request->card_number, // Simpan nomor kartu untuk referensi
                'created_at' => now(),
                'updated_at' => now()
            ]);

            $qty = $request->qty ?? 1;
            // Simpan detail transaksi
            $transactionDetail = TransactionDetail::create([
                'transaction_id' => $transaction->id,
                'product_name' => $request->product_name ?? 'Pembayaran Merchant',
                'price' => $request->amount,
                'description' => 'Pembayaran di merchant ' . $user->merchant->merchant_name,
                'created_at' => now(),
                'updated_at' => now()
            ]);

            // UPDATE KE API BANK UNTUK PROSES PEMBAYARAN (SIMULASI)
            // Simulasi delay proses pembayaran =========================================
            $bankResult = $this->processToBank($request, $transaction->id);
            if ($bankResult->getStatusCode() != 200) {
                // DB::rollBack();
                DB::commit();
                return $this->error('Gagal memproses pembayaran ke bank', 500);
            } else {
                // Update status transaksi menjadi 'paid'
                $transaction->update(['status' => 'paid', 'paid_at' => now()]);
            }

            // ==========================================================================

            // Simpan ke wallet movement, wallet movement ini digunakan untuk mencatat setiap perubahan saldo di e-wallet santri
            $ewalletMovement = WalletMovement::create([
                'ewallet_id' => $ewallet->id,
                'transaction_id' => $transaction->id,
                'type' => 'debit',
                'amount' => $request->amount,
                'balance_before' => $saldoBefore,
                'balance_after' => $saldoAfter,
                'description' => 'Pembayaran di merchant ' . $user->merchant->merchant_name,
            ]);

            // potong saldo
            $ewallet->update([
                'balance' => $saldoAfter
            ]);

            // Simpan ke wallet merchant, wallet movement ini digunakan untuk mencatat setiap perubahan saldo di e-wallet merchant
            $userOwner = User::where('merchant_id', $user->merchant_id)->where('user_level_id', 2)->first(); // get ewallet merchant owner
            $ewalletMerchant = Ewallet::where('user_id', $userOwner->id)->first();
            $saldoBeforeMerchant = $ewalletMerchant->balance;
            $saldoAfterMerchant = $saldoBeforeMerchant + $request->amount;

            $walletMovementMerchant = WalletMovement::create([
                'ewallet_id' => $ewalletMerchant->id,
                'transaction_id' => $transaction->id,
                'type' => 'credit',
                'amount' => $request->amount,
                'balance_before' => $saldoBeforeMerchant,
                'balance_after' => $saldoAfterMerchant,
                'description' => 'Pembayaran di merchant ' . $user->merchant->merchant_name,
            ]);

            // Update saldo e-wallet merchant
            $ewalletMerchant->update([
                'balance' => $saldoAfterMerchant
            ]);

            // Siapkan data notifikasi
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
                'status' => $transaction->status,
                'paid_at' => $transaction->paid_at,
                'created_at' => $transaction->created_at->format('d-m-Y, H:i'),
                'total_pembayaran' => $transaction->paid_amount,
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
        $transaction = Transaction::with('student:id,student_name,nis,class_id,user_id', 'student.ewallet:id,user_id,balance')
            ->where('transaction_code', $code)
            ->first();

        if (!$transaction) {
            return $this->error('Transaksi tidak ditemukan', 404);
        }

        $ewallet = Ewallet::where('user_id', $transaction->student->user_id)->first();

        return $this->success([
            'transaction_code' => $transaction->transaction_code,
            'tanggal' => $transaction->created_at->format('d-m-Y H:i'),
            'nama' => $transaction->student->student_name,
            'nis' => $transaction->student->nis,
            'total_pembayaran' => $transaction->wallet_movements[0]->amount,
            'saldo_sebelum' => $transaction->wallet_movements[0]->balance_before,
            'saldo_sesudah' => $transaction->wallet_movements[0]->balance_after,
            'saldo_terakhir_santri' => $ewallet->balance ?? 0
        ]);
    }



    /**
     * Simulate payment ke bank
     */
    public function processToBank(Request $request, $transactionId)
    {
        $transaction = Transaction::find($transactionId);

        if (!$transaction) {
            return $this->error('Transaksi tidak ditemukan', 404);
        }

        if ($transaction->status != 'pending') {
            return $this->error('Transaksi sudah diproses', 400);
        }

        // Simulasi delay proses pembayaran
        sleep(2);

        return $this->success($transaction, 'Transaksi berhasil diproses ke bank');
        // return $this->error('Gagal memproses pembayaran ke bank', 500);
    }

    /**
     * Generate kode transaksi unik
     */
    function generateTransactionCode()
    {
        do {
            $code = 'TRX-' . now()->format('Ymd') . Str::upper(Str::random(6));
        } while (Transaction::where('transaction_code', $code)->exists());

        return $code;
    }
}
