<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseApiController;
use App\Services\ImageUploadService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use App\Models\News;

class NewsController extends BaseApiController
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 10);

        $news = News::query()
            ->when($request->search, function ($query) use ($request) {
                $query->whereRaw('LOWER(title) like ?', ['%' . strtolower($request->search) . '%']);
            })
            ->latest()
            ->paginate($perPage);

        // transform image_url jadi full URL
        $news->getCollection()->transform(function ($item) {
            if ($item->image_url) {
                $item->image_url = asset($item->image_url);
            }
            return $item;
        });

        return $this->successPaginate($news, 'List of news retrieved successfully');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, ImageUploadService $imageService)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required',
            'author' => 'nullable|string|max:255',
            'is_published' => 'boolean',
            'published_at' => 'nullable|date',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // ambil user_id dari token sanctum
        $data['user_id'] = auth()->id();

        // upload file jika ada
        if ($request->hasFile('image')) {
            $upload = $imageService->upload($request->file('image'), 'news');
            $data['image_url'] = Storage::url($upload['path']);
        }

        $news = News::create($data);

        return $this->success($news, 'News created successfully', 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $news = News::find($id);

        if (!$news) {
            return $this->error('News not found', 404);
        }

        return $this->success($news, 'News retrieved successfully');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id, ImageUploadService $imageService)
    {
        $news = News::findOrFail($id);

        $data = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'content' => 'sometimes|required',
            'author' => 'nullable|string|max:255',
            'is_published' => 'boolean',
            'published_at' => 'nullable|date',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('image')) {
            // delete old image
            $imageService->delete($news->image_url);

            $upload = $imageService->upload($request->file('image'), 'news');
            $data['image_url'] =  Storage::url($upload['path']);
        }

        $news->update($data);

        return $this->success($news, 'News updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id, ImageUploadService $imageService)
    {
        $news = News::findOrFail($id);

        // hapus gambar lama jika ada
        if ($news->image_url) {
            $imageService->delete($news->image_url);
        }

        $news->delete();

        return $this->success(null, 'News deleted successfully');
    }
}
