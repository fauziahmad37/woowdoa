<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ImageUploadService
{
    /**
     * Upload image
     */
    public function upload(UploadedFile $file, string $folder = 'uploads'): array
    {
        // generate unique filename
        $filename = Str::uuid() . '_' . time() . '.' . $file->getClientOriginalExtension();

        // store file
        $path = $file->storeAs($folder, $filename, 'public');

        return [
            'path' => $path,
            'url' => Storage::url($path),
            'filename' => $filename
        ];
    }

    /**
     * Delete image
     */
    public function delete(?string $path): bool
    {
        if (!$path) {
            return false;
        }

        if (Storage::disk('public')->exists($path)) {
            return Storage::disk('public')->delete($path);
        }

        return false;
    }
}
