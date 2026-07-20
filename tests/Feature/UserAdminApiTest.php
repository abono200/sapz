<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Department;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserAdminApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_list_users()
    {
        $admin = User::factory()->create();

        $response = $this->actingAs($admin, 'sanctum')
                         ->getJson('/api/v1/admin/users');

        $response->assertStatus(200)
                 ->assertJson(['success' => true]);
    }

    public function test_user_can_update_own_profile()
    {
        $user = User::factory()->create(['first_name' => 'OldName']);

        $response = $this->actingAs($user, 'sanctum')
                         ->putJson('/api/v1/profile', [
                             'first_name' => 'NewName',
                             'last_name' => 'Updated',
                             'email' => $user->email,
                         ]);

        $response->assertStatus(200)
                 ->assertJsonPath('data.first_name', 'NewName');
    }
}
