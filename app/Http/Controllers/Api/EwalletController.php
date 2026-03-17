<?php

namespace App\Http\Controllers\Api;

use App\Services\FirebaseService;

use App\Http\Controllers\Api\BaseApiController;
use App\Models\Card;
use App\Services\ImageUploadService;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

use App\Models\Settlement;
use App\Models\Transaction;
use App\Models\Parents;
use App\Models\User;
use App\Models\Notification;
use App\Models\Ewallet;
use App\Models\WalletMovement;
use App\Models\Student;

class EwalletController extends BaseApiController
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 10);

        $ewallets = Ewallet::query()
            ->when($request->search, function ($query) use ($request) {
                $query->whereRaw('LOWER(wallet_code) like ?', ['%' . strtolower($request->search) . '%']);
            })
            ->latest()
            ->paginate($perPage);

        $ewallets->getCollection()->transform(function ($item) {
            $item->merchant = $item->merchant;
            return $item;
        });

        return $this->successPaginate($ewallets, 'List of ewallets retrieved successfully');
    }

    /**
     * Process top-up for a merchant's ewallet.
     */
    public function topup(Request $request)
    {
        $request->validate([
            'card_number' => 'required|exists:cards,card_number',
            'amount' => 'required|numeric|min:1',
        ]);

        $student = Student::select('students.id', 'students.student_name', 'students.nis', 'students.user_id', 'students.parent_id')
            ->leftJoin('cards as c', 'students.nis', '=', 'c.nis')
            ->where('c.card_number', $request->card_number)
            ->first();

        $ewallet = Ewallet::where('user_id', $student->user_id)->first();

        // insert ke transactions
        $transaction = Transaction::create([
            'student_id' => $student->id,
            'transaction_code' => $this->generateTransactionCode(),
            'total_amount' => $request->amount,
            'paid_amount' => $request->amount,
            'status' => 'paid',
            'paid_at' => $request->created_at,
            'payment_type_id' => 5, // 5 = top-up ewallet
            'card_number' => $request->card_number,
            'trx_id_bank' => $request->trxid ?? null,
        ]);

        // insert ke wallet movements
        $walletMovement = WalletMovement::create([
            'ewallet_id' => $ewallet->id,
            'transaction_id' => $transaction->id,
            'type' => 'credit',
            'amount' => $request->amount,
            'balance_before' => $ewallet->balance,
            'balance_after' => $ewallet->balance + $request->amount,
            'description' => 'Top-up ewallet',
        ]);

        $ewallet->balance += $request->amount;
        $ewallet->save();

        // Kirim notifikasi ke Firebase
        // Siapkan data notifikasi
        $dataInsert = [
            'title' => 'Top-up Ewallet Berhasil',
            'body' => "Top-up sebesar Rp {$request->amount} berhasil.",
            'is_read' => false,
            'user_id' => $student->user_id, // Notifikasi untuk murid yang melakukan top-up
            'type' => 'topup',
            'data' => [
                'transaction_id' => $transaction->id,
                'transaction_code' => $transaction->transaction_code,
                'amount' => $request->amount,
                'transaction_date' => $request->created_at,
                'saldo_before' => $walletMovement->balance_before,
                'saldo_after' => $walletMovement->balance_after,
            ]
        ];

        // Insert ke table notifikasi untuk wali santri (jika ada)
        $dataInsert['user_id'] = Parents::where('id', $student->parent_id)->value('user_id');
        Notification::create($dataInsert);

        // Push notifikasi menggunakan Firebase Cloud Messaging
        $firebase = new FirebaseService();

        $userIdParent = Parents::where('id', $student->parent_id)->value('user_id'); // Notifikasi untuk wali santri (jika ada)
        $deviceToken = User::where('id', $userIdParent)->value('device_token');
        if ($deviceToken) {
            $firebase->sendNotification(
                $deviceToken,
                "Top-up Ewallet Berhasil",
                "Top-up sebesar Rp {$request->amount} berhasil."
            );
        }


        return $this->success($walletMovement, 'Ewallet topped up successfully');
    }

    /**
     * Display the balance of the authenticated user's ewallet.
     */
    public function balance(Request $request)
    {
        $request->validate([
            'nis' => 'required|exists:students,nis',
        ]);

        $student = Student::where('nis', $request->nis)->first();
        $userId = $student->user_id;
        $ewallet = Ewallet::where('user_id', $userId)->first();

        return $this->success(['balance' => $ewallet->balance], 'Ewallet balance retrieved successfully');
    }

    /**
     * Display the transaction history of the authenticated user's ewallet.
     */
    public function history(Request $request)
    {
        $request->validate([
            'nis' => 'required|exists:students,nis',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        // Ambil data ewallet berdasarkan nis
        $student = Student::where('nis', $request->nis)->first();
        $userId = $student->user_id;
        $ewallet = Ewallet::where('user_id', $userId)->first();
        $history = WalletMovement::where('ewallet_id', $ewallet->id)
            ->when($request->start_date, function ($query) use ($request) {
                $query->where('created_at', '>=', \Carbon\Carbon::parse($request->start_date)->startOfDay());
            })
            ->when($request->end_date, function ($query) use ($request) {
                $query->where('created_at', '<=', \Carbon\Carbon::parse($request->end_date)->endOfDay());
            })
            ->orderBy('created_at', 'desc')
            ->get();
        return $this->success($history, 'Ewallet transaction history retrieved successfully');
    }

    /**
     * Display the balance of the authenticated merchant's ewallet.
     */
    public function balanceMerchant(Request $request)
    {
        $request->validate([
            'username' => 'required|exists:users,username',
        ]);

        $user = User::where('username', $request->username)->first();
        $ewallet = Ewallet::where('user_id', $user->id)->first();
        return $this->success(['balance' => $ewallet->balance], 'Merchant ewallet balance retrieved successfully');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, ImageUploadService $imageService)
    {
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id, ImageUploadService $imageService)
    {
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id, ImageUploadService $imageService)
    {
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
