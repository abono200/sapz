<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;

trait ApiResponse
{
    protected function successResponse($data = null, string $message = 'Success', int $statusCode = 200): JsonResponse
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data,
            'error' => null,
            'meta' => [
                'timestamp' => now()->toIso8601String(),
                'version' => 'v1'
            ]
        ], $statusCode);
    }

    protected function errorResponse(string $error, int $statusCode = 400, $details = null): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => 'An error occurred',
            'data' => null,
            'error' => [
                'code' => $statusCode,
                'message' => $error,
                'details' => $details
            ],
            'meta' => [
                'timestamp' => now()->toIso8601String(),
                'version' => 'v1'
            ]
        ], $statusCode);
    }

    protected function paginatedResponse($paginator, string $message = 'Data retrieved successfully'): JsonResponse
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $paginator->items(),
            'error' => null,
            'meta' => [
                'pagination' => [
                    'current_page' => $paginator->currentPage(),
                    'per_page' => $paginator->perPage(),
                    'total' => $paginator->total(),
                    'last_page' => $paginator->lastPage(),
                ],
                'timestamp' => now()->toIso8601String(),
                'version' => 'v1'
            ]
        ], 200);
    }
}
