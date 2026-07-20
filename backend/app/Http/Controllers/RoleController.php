<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateRoleRequest;
use App\Http\Requests\SyncPermissionsRequest;
use App\Models\Role;
use App\Services\RbacService;
use App\Traits\ApiResponse;

class RoleController extends Controller
{
    use ApiResponse;

    protected $rbacService;

    public function __construct(RbacService $rbacService)
    {
        $this->rbacService = $rbacService;
    }

    public function index()
    {
        $roles = $this->rbacService->getAllRoles();
        return $this->successResponse($roles, 'Role matrix retrieved.');
    }

    public function store(CreateRoleRequest $request)
    {
        $role = $this->rbacService->createRole($request->validated());
        return $this->successResponse($role, 'Role created successfully.', 201);
    }

    public function syncPermissions(SyncPermissionsRequest $request, string $id)
    {
        $role = Role::find($id);
        if (!$role) {
            return $this->errorResponse('Role not found.', 404);
        }

        $updatedRole = $this->rbacService->syncRolePermissions($role, $request->permission_ids);
        return $this->successResponse($updatedRole, 'Role permissions updated successfully.');
    }
}
