<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateDocumentRequest;
use App\Http\Requests\UploadDocumentVersionRequest;
use App\Models\Document;
use App\Services\DocumentRegistryService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    use ApiResponse;

    protected $documentService;

    public function __construct(DocumentRegistryService $documentService)
    {
        $this->documentService = $documentService;
    }

    public function index(Request $request)
    {
        $filters = $request->only(['category', 'security_classification', 'project_id', 'search']);
        $documents = $this->documentService->getDocuments($filters, $request->input('per_page', 15));
        return $this->paginatedResponse($documents, 'Document registry retrieved.');
    }

    public function store(CreateDocumentRequest $request)
    {
        $file = $request->file('file');
        $document = $this->documentService->createDocument($request->validated(), $file);
        return $this->successResponse($document, 'Document registered successfully.', 201);
    }

    public function show(string $id)
    {
        $document = Document::with(['author', 'project'])->find($id);
        if (!$document) {
            return $this->errorResponse('Document not found.', 404);
        }
        return $this->successResponse($document, 'Document details retrieved.');
    }

    public function uploadVersion(UploadDocumentVersionRequest $request, string $id)
    {
        $document = Document::find($id);
        if (!$document) {
            return $this->errorResponse('Document not found.', 404);
        }

        $version = $this->documentService->addVersion($document, $request->version_number, $request->file('file'));
        return $this->successResponse($version, 'New document version uploaded.', 201);
    }

    public function download(string $id)
    {
        $document = Document::find($id);
        if (!$document) {
            return $this->errorResponse('Document not found.', 404);
        }

        $this->documentService->logDownload($document);
        return $this->successResponse(['download_url' => "/storage/documents/{$document->id}/latest"], 'Document download logged.');
    }
}
