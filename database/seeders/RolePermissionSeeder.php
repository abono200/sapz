<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            'Super Admin' => 'Full System Administrator Access',
            'Programme Director' => 'Executive Management & Programme Oversight',
            'Project Manager' => 'Project Lifecycle & Task Execution Lead',
            'Knowledge Officer' => 'CKR Content & Knowledge Base Curator',
            'Technical Auditor' => 'System Audit & Quality Reviewer',
        ];

        foreach ($roles as $name => $desc) {
            Role::firstOrCreate(['name' => $name], ['guard_name' => 'web', 'description' => $desc]);
        }

        $permissions = [
            'users.create', 'users.read', 'users.update', 'users.delete',
            'documents.create', 'documents.read', 'documents.update', 'documents.approve',
            'projects.create', 'projects.read', 'projects.update', 'projects.delete',
            'workflows.execute', 'reports.view', 'analytics.view'
        ];

        foreach ($permissions as $perm) {
            Permission::firstOrCreate(['name' => $perm], ['guard_name' => 'web', 'category' => explode('.', $perm)[0]]);
        }
    }
}
