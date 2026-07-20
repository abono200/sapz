<?php

namespace App\Http\Controllers;

use App\Http\Requests\AssignRoleRequest;
use App\Models\User;
use App\Services\RbacService;
use App\Traits\ApiResponse;

class UserRoleController extends Controller
{
    use ApiResponse;

    protected $rbacService;

    public function __construct(RbacService $rbacService)
    {
        $this->rbacService = $rbacService;
    }

    public function assignRole(AssignRoleRequest $request, string $userId)
    {
        $user = User::find($userId);
        if (!$user) {
            return $this->errorResponse('User not found.', 404);
        }

        $this->rbacService->assignRoleToUser($user, $request->role_id);
        return $this->successResponse(null, 'Role assigned to user successfully.');
    }

    public function removeRole(string $userId, string $roleId)
    {
        $user = User::find($userId);
        if (!$user) {
            return $this->errorResponse('User not found.', 404);
        }

        $this->rbacService->removeRoleFromUser($user, $roleId);
        return $this->successResponse(null, 'Role removed from user.');
    }
}
