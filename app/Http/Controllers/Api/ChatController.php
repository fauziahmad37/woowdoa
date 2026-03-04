<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseApiController;
use App\Models\Message;
use App\Models\Conversation;
use App\Services\FirebaseService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\User;
use App\Models\Student;
use App\Models\Teacher;

class ChatController extends BaseApiController
{

    /**
     * GET CONTACTS
     */
    public function contacts(Request $request)
    {
        $user = auth()->user();

        if (!$user->school_id) {
            return $this->error('User tidak memiliki sekolah', 400);
        }

        $perPage = $request->get('per_page', 10);
        $search  = $request->get('search');

        $query = User::where('school_id', $user->school_id)
            ->where('id', '!=', $user->id);

        // Parent → ambil teacher
        if ($user->user_level_id == 5) {
            $query->where('user_level_id', 4);
        }
        // Teacher → ambil parent
        elseif ($user->user_level_id == 4) {
            $query->where('user_level_id', 5);
        } else {
            return $this->error('Role tidak diizinkan', 403);
        }

        if ($search) {
            $query->where('complete_name', 'ILIKE', "%{$search}%");
        }

        $contacts = $query
            ->select('id', 'complete_name', 'profile_photo')
            ->paginate($perPage);

        $contacts->getCollection()->transform(function ($item) {
            $item->profile_photo = $item->profile_photo
                ? asset($item->profile_photo)
                : null;
            return $item;
        });

        return $this->successPaginate($contacts, 'Daftar kontak');
    }

    /**
     * START CONVERSATION
     */
    public function startConversation(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id'
        ]);

        $authUser = auth()->user();
        $targetUser = User::findOrFail($request->user_id);

        // Cek school sama
        if ($authUser->school_id !== $targetUser->school_id) {
            return $this->error('Tidak satu sekolah', 403);
        }

        // Validasi role
        if (!in_array($authUser->user_level_id, [4, 5])) {
            return $this->error('Role tidak diizinkan', 403);
        }

        DB::beginTransaction();
        try {

            $parentId = $authUser->user_level_id == 5
                ? $authUser->id
                : $targetUser->id;

            $teacherId = $authUser->user_level_id == 4
                ? $authUser->id
                : $targetUser->id;

            $conversation = Conversation::firstOrCreate(
                [
                    'parent_id'  => $parentId,
                    'teacher_id' => $teacherId,
                ],
                [
                    'last_message_at' => now()
                ]
            );

            DB::commit();

            return $this->success($conversation, 'Conversation siap');
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->error($e->getMessage(), 500);
        }
    }

    /**
     * SEND MESSAGE
     */
    public function sendMessage(Request $request, FirebaseService $firebase)
    {
        $request->validate([
            'conversation_id' => 'required|exists:conversations,id',
            'message' => 'required|string|max:2000'
        ]);

        $user = auth()->user();

        DB::beginTransaction();
        try {

            $conversation = Conversation::lockForUpdate()
                ->findOrFail($request->conversation_id);

            // Authorization check
            if (!in_array($user->id, [
                $conversation->parent_id,
                $conversation->teacher_id
            ])) {
                return $this->error('Tidak diizinkan', 403);
            }

            $message = Message::create([
                'conversation_id' => $conversation->id,
                'sender_id'       => $user->id,
                'message'         => $request->message,
                'is_read'         => false
            ]);

            $conversation->update([
                'last_message_at' => now()
            ]);

            // Tentukan penerima
            $receiverId = $conversation->parent_id == $user->id
                ? $conversation->teacher_id
                : $conversation->parent_id;


            $receiver = User::find($receiverId);

            DB::commit();

            // Kirim FCM setelah commit
            if ($receiver && $receiver->device_token) {
                $firebase->sendNotification(
                    $receiver->device_token,
                    "Pesan Baru",
                    $user->complete_name . ": " . $message->message,
                    [
                        "conversation_id" => (string) $conversation->id,
                        "type" => "chat"
                    ]
                );
            }

            return $this->success($message, 'Pesan terkirim');
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->error($e->getMessage(), 500);
        }
    }

    /**
     * GET MESSAGES
     */
    public function getMessages($conversationId)
    {
        $user = auth()->user();

        $conversation = Conversation::findOrFail($conversationId);

        if (!in_array($user->id, [
            $conversation->parent_id,
            $conversation->teacher_id
        ])) {
            return $this->error('Tidak diizinkan', 403);
        }

        // Mark as read
        Message::where('conversation_id', $conversationId)
            ->where('sender_id', '!=', $user->id)
            ->where('is_read', false)
            ->update(['is_read' => true]);

        $messages = Message::where('conversation_id', $conversationId)
            ->with('sender:id,complete_name')
            ->orderByDesc('created_at')
            ->paginate(20);

        return $this->successPaginate($messages, 'Daftar pesan');
    }

    /**
     * GET CONVERSATIONS
     */
    public function conversations()
    {
        $userId = auth()->id();

        $conversations = Conversation::where(function ($q) use ($userId) {
            $q->where('parent_id', $userId)
                ->orWhere('teacher_id', $userId);
        })
            ->withCount(['messages as unread_count' => function ($q) use ($userId) {
                $q->where('is_read', false)
                    ->where('sender_id', '!=', $userId);
            }])
            ->orderByDesc('last_message_at')
            ->paginate(20);

        return $this->successPaginate($conversations, 'Daftar percakapan');
    }
}
