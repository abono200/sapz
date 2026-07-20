<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterApiClientRequest;
use App\Http\Requests\RegisterWebhookRequest;
use App\Models\ApiClient;
use App\Services\SystemIntegrationService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class SystemIntegrationController extends Controller
{
    use ApiResponse;

    protected $integrationService;

    public function __construct(SystemIntegrationService $integrationService)
    {
        $this->integrationService = $integrationService;
    }

    public function apiClients()
    {
        $clients = ApiClient::paginate(15);
        return $this->paginatedResponse($clients, 'API integration clients list retrieved.');
    }

    public function registerClient(RegisterApiClientRequest $request)
    {
        $credentials = $this->integrationService->registerClient($request->validated());
        return $this->successResponse($credentials, 'API integration client registered successfully.', 201);
    }

    public function registerWebhook(RegisterWebhookRequest $request)
    {
        $webhook = $this->integrationService->registerWebhook($request->validated());
        return $this->successResponse($webhook, 'Webhook endpoint registered successfully.', 201);
    }

    public function openApiSpec()
    {
        $spec = [
            'openapi' => '3.1.0',
            'info' => [
                'title' => 'SAPZ ESM & CKR Enterprise API Platform',
                'version' => '1.0.0',
                'description' => 'Official Open API Specification for SAPZ Platform integration with IFAD, AfDB, IsDB, and Federal Government systems.'
            ],
            'paths' => [
                '/api/v1/health' => ['get' => ['summary' => 'System Health Status']],
                '/api/v1/projects' => ['get' => ['summary' => 'List Projects']],
                '/api/v1/documents' => ['get' => ['summary' => 'Document Registry']],
                '/api/v1/ckr/articles' => ['get' => ['summary' => 'Public Knowledge Articles']],
            ]
        ];

        return response()->json($spec);
    }
}
