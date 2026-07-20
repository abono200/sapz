<?php

namespace App\Http\Controllers;

use App\Http\Requests\UploadMediaRequest;
use App\Models\MediaAsset;
use App\Services\MediaStorageService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class MediaController extends Controller
{
    use ApiResponse;

    protected $mediaService;

    public function __construct(MediaStorageService $mediaService)
    {
        $this->mediaService = $mediaService;
    }

    public function index(Request $request)
    {
        $filters = $request->only(['mime_type', 'search']);
        $assets = $this->mediaService->getMediaAssets($filters, $request->input('per_page', 15));
        return $this->paginatedResponse($assets, 'Media asset registry retrieved.');
    }

    public function store(UploadMediaRequest $request)
    {
        $disk = $request->input('disk', 'public');
        $asset = $this->mediaService->uploadMedia($request->file('file'), $disk);
        return $this->successResponse($asset, 'Media asset uploaded successfully.', 201);
    }

    public function show(string $id)
    {
        $asset = MediaAsset::with('uploader')->find($id);
        if (!$asset) {
            return $this->errorResponse('Media asset not found.', 404);
        }
        return $this->successResponse($asset, 'Media asset details retrieved.');
    }

    public function getSignedUrl(string $id)
    {
        $asset = MediaAsset::find($id);
        if (!$asset) {
            return $this->errorResponse('Media asset not found.', 404);
        }

        try {
            $signedUrl = $this->mediaService->generateSignedUrl($asset);
            return $this->successResponse(['signed_url' => $signedUrl, 'expires_in_minutes' => 30], 'Pre-signed temporary URL generated.');
        } catch (\Exception $e) {
            return $this->successResponse(['url' => $asset->url], 'Public URL retrieved.');
        }
    }

    public function destroy(string $id)
    {
        $asset = MediaAsset::find($id);
        if (!$asset) {
            return $this->errorResponse('Media asset not found.', 404);
        }

        $asset->delete();
        return $this->successResponse(null, 'Media asset archived successfully.');
    }
}
