<?php

namespace App\Services;

use App\Models\MediaAsset;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MediaStorageService
{
    public function getMediaAssets(array $filters = [], int $perPage = 15)
    {
        $query = MediaAsset::with('uploader');

        if (!empty($filters['mime_type'])) {
            $query->where('mime_type', 'LIKE', "%{$filters['mime_type']}%");
        }

        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $query->where('original_name', 'ILIKE', "%{$search}%");
        }

        return $query->orderBy('created_at', 'desc')->paginate($perPage);
    }

    public function uploadMedia(UploadedFile $file, string $disk = 'public'): MediaAsset
    {
        $hash = hash_file('sha256', $file->getRealPath());
        $fileName = Str::uuid() . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs('media', $fileName, $disk);

        $url = Storage::disk($disk)->url($path);

        $dimensions = @getimagesize($file->getRealPath());
        $width = $dimensions ? $dimensions[0] : null;
        $height = $dimensions ? $dimensions[1] : null;

        return MediaAsset::create([
            'disk' => $disk,
            'file_name' => $fileName,
            'original_name' => $file->getClientOriginalName(),
            'mime_type' => $file->getMimeType(),
            'file_size' => $file->getSize(),
            'width' => $width,
            'height' => $height,
            'sha256_hash' => $hash,
            'url' => $url,
            'uploaded_by' => Auth::id(),
        ]);
    }

    public function generateSignedUrl(MediaAsset $asset, int $expirationMinutes = 30): string
    {
        return Storage::disk($asset->disk)->temporaryUrl(
            'media/' . $asset->file_name,
            now()->addMinutes($expirationMinutes)
        );
    }
}
