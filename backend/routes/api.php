<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HealthCheckController;
use App\Http\Controllers\MetricsController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserAdminController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\UserRoleController;
use App\Http\Controllers\ExecutiveDashboardController;
use App\Http\Controllers\ProgrammeController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\WorkflowController;
use App\Http\Controllers\ApprovalSignoffController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\CkrPublicController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\AiSearchController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\MobileSyncController;
use App\Http\Controllers\AnalyticsReportController;
use App\Http\Controllers\SystemIntegrationController;

/*
|--------------------------------------------------------------------------
| SAPZ ESM & CKR API V1 Routes
|--------------------------------------------------------------------------
*/

Route::prefix('v1')->group(function () {

    // Public Health & Prometheus Metrics & OpenAPI Spec
    Route::get('/health', HealthCheckController::class);
    Route::get('/metrics', MetricsController::class);
    Route::get('/docs/openapi.json', [SystemIntegrationController::class, 'openApiSpec']);

    // Public CKR Knowledge Repository Routes
    Route::get('/ckr/articles', [CkrPublicController::class, 'index']);
    Route::get('/ckr/articles/{slug}', [CkrPublicController::class, 'show']);
    Route::get('/ckr/articles/{id}/citation', [CkrPublicController::class, 'citation']);
    Route::get('/ckr/categories', [CkrPublicController::class, 'categories']);

    // Authentication Routes
    Route::post('/auth/login', [AuthController::class, 'login']);

    // Protected Routes (Sanctum)
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/auth/me', [AuthController::class, 'me']);
        Route::post('/auth/logout', [AuthController::class, 'logout']);

        // Profile Management
        Route::put('/profile', [ProfileController::class, 'updateProfile']);
        Route::put('/profile/password', [ProfileController::class, 'updatePassword']);

        // System Integration & Webhook Routes
        Route::post('/webhooks', [SystemIntegrationController::class, 'registerWebhook']);

        // Analytics & Reporting Routes
        Route::get('/analytics/kpi-summary', [AnalyticsReportController::class, 'kpiSummary']);
        Route::get('/analytics/charts/project-budget', [AnalyticsReportController::class, 'budgetChart']);
        Route::get('/analytics/reports', [AnalyticsReportController::class, 'index']);
        Route::post('/analytics/reports/generate', [AnalyticsReportController::class, 'generate']);
        Route::get('/analytics/reports/{id}/download', [AnalyticsReportController::class, 'download']);

        // Mobile Data Collection & Offline Sync Routes
        Route::post('/mobile/sync', [MobileSyncController::class, 'batchSync']);
        Route::get('/mobile/inspections', [MobileSyncController::class, 'index']);
        Route::post('/mobile/inspections', [MobileSyncController::class, 'store']);
        Route::get('/mobile/sync-history', [MobileSyncController::class, 'syncHistory']);

        // Notifications & Communication Routes
        Route::get('/notifications', [NotificationController::class, 'index']);
        Route::post('/notifications/{id}/read', [NotificationController::class, 'markRead']);
        Route::post('/notifications/read-all', [NotificationController::class, 'markAllRead']);
        Route::get('/notifications/preferences', [NotificationController::class, 'getPreferences']);
        Route::put('/notifications/preferences', [NotificationController::class, 'updatePreferences']);

        // Hybrid Semantic Search & AI RAG Assistant Routes
        Route::get('/search/semantic', [AiSearchController::class, 'search']);
        Route::post('/ai/assistant/chat', [AiSearchController::class, 'chat']);
        Route::get('/ai/assistant/conversations', [AiSearchController::class, 'conversations']);

        // Media & Storage Management Routes
        Route::get('/media', [MediaController::class, 'index']);
        Route::post('/media/upload', [MediaController::class, 'store']);
        Route::get('/media/{id}', [MediaController::class, 'show']);
        Route::get('/media/{id}/signed-url', [MediaController::class, 'getSignedUrl']);
        Route::delete('/media/{id}', [MediaController::class, 'destroy']);

        // CKR Article Management
        Route::post('/admin/ckr/articles', [CkrPublicController::class, 'store']);

        // Executive Dashboard
        Route::prefix('executive')->group(function () {
            Route::get('/summary', [ExecutiveDashboardController::class, 'summary']);
            Route::get('/programmes', [ExecutiveDashboardController::class, 'programmes']);
            Route::get('/departments', [ExecutiveDashboardController::class, 'departments']);
            Route::get('/activity', [ExecutiveDashboardController::class, 'activity']);
        });

        // Programme Management
        Route::get('/programmes', [ProgrammeController::class, 'index']);
        Route::post('/programmes', [ProgrammeController::class, 'store']);
        Route::get('/programmes/{id}', [ProgrammeController::class, 'show']);
        Route::post('/programmes/{id}/milestones', [ProgrammeController::class, 'addMilestone']);

        // Projects Management
        Route::get('/projects', [ProjectController::class, 'index']);
        Route::post('/projects', [ProjectController::class, 'store']);
        Route::get('/projects/{id}', [ProjectController::class, 'show']);
        Route::put('/projects/{id}', [ProjectController::class, 'update']);
        Route::delete('/projects/{id}', [ProjectController::class, 'destroy']);
        Route::get('/project-zones', [ProjectController::class, 'zones']);

        // Task Management
        Route::get('/tasks', [TaskController::class, 'index']);
        Route::post('/tasks', [TaskController::class, 'store']);
        Route::get('/tasks/{id}', [TaskController::class, 'show']);
        Route::put('/tasks/{id}', [TaskController::class, 'update']);
        Route::delete('/tasks/{id}', [TaskController::class, 'destroy']);
        Route::post('/tasks/{id}/comments', [TaskController::class, 'addComment']);

        // Document Registry Management
        Route::get('/documents', [DocumentController::class, 'index']);
        Route::post('/documents', [DocumentController::class, 'store']);
        Route::get('/documents/{id}', [DocumentController::class, 'show']);
        Route::post('/documents/{id}/versions', [DocumentController::class, 'uploadVersion']);
        Route::get('/documents/{id}/download', [DocumentController::class, 'download']);

        // Workflow & Approval Engine
        Route::get('/workflows', [WorkflowController::class, 'index']);
        Route::post('/workflows', [WorkflowController::class, 'store']);
        Route::post('/approvals/submit', [WorkflowController::class, 'submitApproval']);
        Route::post('/approvals/{id}/approve', [WorkflowController::class, 'approve']);
        Route::post('/approvals/{id}/reject', [WorkflowController::class, 'reject']);

        // Approvals Signoff & Delegation Suite
        Route::get('/approvals/inbox', [ApprovalSignoffController::class, 'inbox']);
        Route::post('/approvals/{id}/signoff', [ApprovalSignoffController::class, 'signoff']);
        Route::post('/approvals/{id}/request-revision', [ApprovalSignoffController::class, 'requestRevision']);
        Route::post('/approvals/delegations', [ApprovalSignoffController::class, 'createDelegation']);

        // Department Management
        Route::get('/departments', [DepartmentController::class, 'index']);
        Route::post('/departments', [DepartmentController::class, 'store']);

        // Security & Admin Management Routes
        Route::prefix('admin')->group(function () {
            Route::get('/users', [UserAdminController::class, 'index']);
            Route::post('/users', [UserAdminController::class, 'store']);
            Route::get('/users/{id}', [UserAdminController::class, 'show']);
            Route::put('/users/{id}', [UserAdminController::class, 'update']);
            Route::delete('/users/{id}', [UserAdminController::class, 'destroy']);

            // API Clients Management
            Route::get('/api-clients', [SystemIntegrationController::class, 'apiClients']);
            Route::post('/api-clients', [SystemIntegrationController::class, 'registerClient']);

            // Roles & Permissions
            Route::get('/roles', [RoleController::class, 'index']);
            Route::post('/roles', [RoleController::class, 'store']);
            Route::post('/roles/{id}/permissions', [RoleController::class, 'syncPermissions']);
            Route::get('/permissions', [PermissionController::class, 'index']);

            // User Roles Assignment
            Route::post('/users/{userId}/roles', [UserRoleController::class, 'assignRole']);
            Route::delete('/users/{userId}/roles/{roleId}', [UserRoleController::class, 'removeRole']);
        });
    });
});
