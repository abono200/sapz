<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SecurityRbacTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_create_role()
    {
        $admin = User::factory()->create();

        $response = $this->actingAs($admin, 'sanctum')
                         ->postJson('/api/v1/admin/roles', [
                             'name' => 'Auditor General',
                             'description' => 'External Audit Lead Role',
                         ]);

        $response->assertStatus(201)
                 ->assertJsonPath('data.name', 'Auditor General');
    }

    public function test_admin_can_assign_role_to_user()
    {
        $admin = User::factory()->create();
        $user = User::factory()->create();
        $role = Role::create(['name' => 'Project Manager']);

        $response = $this->actingAs($admin, 'sanctum')
                         ->postJson("/api/v1/admin/users/{$user->id}/roles", [
                             'role_id' => $role->id,
                         ]);

        $response->assertStatus(200)
                 ->assertJson(['success' => true]);
    }
}
