<?php

namespace App\Services;

use App\Models\Document;
use App\Models\DocumentDownload;
use App\Models\DocumentVersion;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DocumentRegistryService
{
    public function getDocuments(array $filters = [], int $perPage = 15)
    {
        $query = Document::with(['author', 'project']);

        if (!empty($filters['category'])) {
            $query->where('category', $filters['category']);
        }

        if (!empty($filters['security_classification'])) {
            $query->where('security_classification', $filters['security_classification']);
        }

        if (!empty($filters['project_id'])) {
            $query->where('project_id', $filters['project_id']);
        }

        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function($q) use ($search) {
                $q->where('title', 'ILIKE', "%{$search}%")
                  ->orWhere('reference_number', 'ILIKE', "%{$search}%");
            });
        }

        return $query->paginate($perPage);
    }

    public function createDocument(array $data, ?UploadedFile $file = null): Document
    {
        $data['author_id'] = Auth::id();
        $document = Document::create($data);

        if ($file) {
            $this->addVersion($document, '1.0', $file);
        }

        return $document;
    }

    public function addVersion(Document $document, string $versionNumber, UploadedFile $file): DocumentVersion
    {
        $path = $file->store('documents/' . $document->id, 'public');
        $hash = hash_file('sha256', $file->getRealPath());

        return DocumentVersion::create([
            'document_id' => $document->id,
            'version_number' => $versionNumber,
            'file_path' => $path,
            'file_size' => $file->getSize(),
            'mime_type' => $file->getMimeType(),
            'sha256_hash' => $hash,
            'uploaded_by' => Auth::id(),
        ]);
    }

    public function logDownload(Document $document, ?DocumentVersion $version = null): void
    {
        DocumentDownload::create([
            'id' => (string) Str::uuid(),
            'document_id' => $document->id,
            'version_id' => $version ? $version->id : null,
            'downloaded_by' => Auth::id(),
            'ip_address' => request()->ip(),
            'created_at' => now(),
        ]);
    }
}
