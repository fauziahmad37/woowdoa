<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $news = News::where('is_published', true)
            ->orderBy('published_at', 'desc')
            ->paginate(10);

        return response()->json([
            'success' => true,
            'data' => $news,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'author' => 'nullable|string|max:255',
            'image' => 'nullable|string',
            'is_published' => 'boolean',
            'published_at' => 'nullable|date',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        $news = News::create($validator->validated());

        return response()->json([
            'success' => true,
            'message' => 'Berita berhasil dibuat',
            'data' => $news,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $news = News::find($id);

        if (!$news) {
            return response()->json([
                'success' => false,
                'message' => 'Berita tidak ditemukan',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $news,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $news = News::find($id);

        if (!$news) {
            return response()->json([
                'success' => false,
                'message' => 'Berita tidak ditemukan',
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'title' => 'sometimes|required|string|max:255',
            'content' => 'sometimes|required|string',
            'author' => 'nullable|string|max:255',
            'image' => 'nullable|string',
            'is_published' => 'boolean',
            'published_at' => 'nullable|date',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        $news->update($validator->validated());

        return response()->json([
            'success' => true,
            'message' => 'Berita berhasil diperbarui',
            'data' => $news,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $news = News::find($id);

        if (!$news) {
            return response()->json([
                'success' => false,
                'message' => 'Berita tidak ditemukan',
            ], 404);
        }

        $news->delete();

        return response()->json([
            'success' => true,
            'message' => 'Berita berhasil dihapus',
        ]);
    }
}
