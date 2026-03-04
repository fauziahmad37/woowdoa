<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseApiController;
use App\Services\ImageUploadService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

// use App\Models\UserDevice;
use App\Models\User;
use App\Services\FirebaseService;
use App\Models\Events;

class EventsController extends BaseApiController
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 10);

        $events = Events::query()
            ->when($request->search, function ($query) use ($request) {
                $query->whereRaw('LOWER(title) like ?', ['%' . strtolower($request->search) . '%']);
            })
            ->latest()
            ->paginate($perPage);

        // transform image_url jadi full URL
        $events->getCollection()->transform(function ($item) {
            if ($item->image_url) {
                $item->image_url = asset($item->image_url);
            }
            return $item;
        });

        return $this->successPaginate($events, 'List of events retrieved successfully');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, ImageUploadService $imageService)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after_or_equal:start_time',
            'location' => 'nullable|string|max:255',
            'organizer' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // ambil user_id dari token sanctum
        $data['user_id'] = auth()->id();

        // upload file jika ada
        if ($request->hasFile('image')) {
            $upload = $imageService->upload($request->file('image'), 'events');
            $data['image_url'] = Storage::url($upload['path']);
        }

        $event = Events::create($data);

        $firebase = new FirebaseService();

        $tokens = User::whereNotNull('device_token')
            ->pluck('device_token');

        foreach ($tokens as $token) {
            $firebase->sendNotification(
                $token,
                "Event Baru 🎉",
                $event->title
            );
        }

        return $this->success($event, 'Event created successfully', 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $event = Events::find($id);

        if (!$event) {
            return $this->error('Event not found', 404);
        }

        // transform image_url jadi full URL
        if ($event->image_url) {
            $event->image_url = asset($event->image_url);
        }

        return $this->success($event, 'Event retrieved successfully');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id, ImageUploadService $imageService)
    {
        $event = Events::findOrFail($id);

        $data = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|required',
            'start_time' => 'sometimes|required|date',
            'end_time' => 'sometimes|required|date|after_or_equal:start_time',
            'location' => 'nullable|string|max:255',
            'organizer' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('image')) {
            // delete old image
            $imageService->delete($event->image_url);

            $upload = $imageService->upload($request->file('image'), 'events');
            $data['image_url'] =  Storage::url($upload['path']);
        }

        $event->update($data);

        return $this->success($event, 'Event updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id, ImageUploadService $imageService)
    {
        $event = Events::findOrFail($id);

        // hapus gambar lama jika ada
        if ($event->image_url) {
            $imageService->delete($event->image_url);
        }

        $event->delete();

        return $this->success(null, 'Event deleted successfully');
    }
}
