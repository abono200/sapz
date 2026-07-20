<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRoleAndPermissions
{
    public function handle(Request $request, Closure $next, string $permission): Response
    {
        $user = $request->user();

        if (!$user) {
            return response()->json([
                'success' => false,
                'error' => 'Unauthenticated access attempt.',
                'meta' => ['timestamp' => now()->toIso8601String()]
            ], 401);
        }

        // Admin override
        if ($user->hasRole('Super Admin')) {
            return $next($request);
        }

        if (!$user->hasPermissionTo($permission)) {
            return response()->json([
                'success' => false,
                'error' => "Forbidden: Missing required permission [{$permission}].",
                'meta' => ['timestamp' => now()->toIso8601String()]
            ], 403);
        }

        return $next($request);
    }
}
