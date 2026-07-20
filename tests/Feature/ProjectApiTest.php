<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProjectApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_create_project()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user, 'sanctum')
                         ->postJson('/api/v1/projects', [
                             'code' => 'PRJ-KANO-01',
                             'title' => 'Kano Agro-Processing Hub Construction',
                             'status' => 'ACTIVE',
                             'budget' => 45000000.00,
                         ]);

        $response->assertStatus(201)
                 ->assertJsonPath('data.code', 'PRJ-KANO-01');
    }
}
