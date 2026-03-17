<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseApiController;
use App\Models\Notification;
use Illuminate\Http\Request;
use Carbon\Carbon;

class NotificationController extends BaseApiController
{
    /**
     * GET List History Notifikasi
     */
    public function index(Request $request)
    {
        $user = auth()->user();

        $query = Notification::query()
            ->where('user_id', $user->id);

        // 🔎 Filter Start Date
        if ($request->filled('start_date')) {
            $start = Carbon::parse($request->start_date)->startOfDay();
            $query->where('created_at', '>=', $start);
        }

        // 🔎 Filter End Date
        if ($request->filled('end_date')) {
            $end = Carbon::parse($request->end_date)->endOfDay();
            $query->where('created_at', '<=', $end);
        }

        // 🔎 Filter Status Read
        if ($request->filled('is_read')) {
            $query->where('is_read', $request->is_read);
        }

        $unreadCount = (clone $query)->where('is_read', false)->count();

        $query->orderBy('created_at', 'desc');

        $perPage = $request->get('per_page', 10);

        $notifications = $query->paginate($perPage);

        $notifications->each(function ($notification) {
            $data = $notification->data;

            $notification->transaction_code = $data['transaction_code'] ?? null;
            $notification->transaction_date = $data['transaction_date'] ?? null;
            $notification->amount = isset($data['amount']) ? number_format($data['amount'], 0, ',', '.') : null;
            $notification->saldo_before = isset($data['saldo_before']) ? number_format($data['saldo_before'], 0, ',', '.') : null;
            $notification->saldo_after = isset($data['saldo_after']) ? number_format($data['saldo_after'], 0, ',', '.') : null;
        });

        return $this->successPaginate(
            $notifications,
            'List history notifikasi berhasil diambil',
            ['unread_count' => $unreadCount]
        );
    }

    /**
     * Update status read / unread notifikasi
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'is_read' => 'required|boolean',
        ]);

        $user = auth()->user();

        $notification = Notification::where('id', $id)
            ->where('user_id', $user->id)
            ->first();

        if (!$notification) {
            return $this->error('Notifikasi tidak ditemukan', 404);
        }

        $notification->update([
            'is_read' => $request->is_read
        ]);

        $unreadCount = Notification::where('user_id', $user->id)
            ->where('is_read', false)
            ->count();

        return $this->success(['notification' => $notification, 'unread_count' => $unreadCount], 'Status notifikasi berhasil diperbarui');
    }
}
