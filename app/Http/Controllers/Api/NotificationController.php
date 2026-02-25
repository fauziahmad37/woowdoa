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

        $query->orderBy('created_at', 'desc');

        $perPage = $request->get('per_page', 10);

        $notifications = $query->paginate($perPage);

        return $this->successPaginate(
            $notifications,
            'List history notifikasi berhasil diambil'
        );
    }
}
