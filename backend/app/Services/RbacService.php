<?php

namespace App\Services;

use App\Models\Role;
use App\Models\Permission;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class RbacService
{
    protected $auditService;

    public function __construct(SecurityAuditService $auditService)
    {
        $this->auditService = $auditService;
    }

    public function getAllRoles()
    {
        return Role::with('permissions')->get();
    }

    public function createRole(array $data): Role
    {
        $role = Role::create($data);
        $this->auditService->log('ROLE_CREATE', Role::class, $role->id, [], $data);
        return $role;
    }

    public function syncRolePermissions(Role $role, array $permissionIds): Role
    {
        $oldPerms = $role->permissions()->pluck('id')->toArray();
        DB::table('role_has_permissions')->where('role_id', $role->id)->delete();

        foreach ($permissionIds as $pId) {
            DB::table('role_has_permissions')->insert([
                'role_id' => $role->id,
                'permission_id' => $pId
            ]);
        }

        $this->auditService->log('ROLE_PERMISSIONS_SYNC', Role::class, $role->id, $oldPerms, $permissionIds);
        return $role->fresh(['permissions']);
    }

    public function assignRoleToUser(User $user, string $roleId): void
    {
        DB::table('user_has_roles')->updateOrInsert(
            ['user_id' => $user->id, 'role_id' => $roleId]
        );
        $this->auditService->log('USER_ROLE_ASSIGN', User::class, $user->id, [], ['role_id' => $roleId]);
    }

    public function removeRoleFromUser(User $user, string $roleId): void
    {
        DB::table('user_has_roles')->where('user_id', $user->id)->where('role_id', $roleId)->delete();
        $this->auditService->log('USER_ROLE_REMOVE', User::class, $user->id, ['role_id' => $roleId], []);
    }

    // ABAC Security Check: Verifies Department Boundary & Security Classification Access
    public function canAccessResource(User $user, string $securityClassification, ?string $departmentId = null): bool
    {
        // Admin override
        if ($user->department && $user->department->code === 'ICT') {
            return true;
        }

        if ($securityClassification === 'CONFIDENTIAL' && $user->department_id !== $departmentId) {
            return false;
        }

        return true;
    }
}
