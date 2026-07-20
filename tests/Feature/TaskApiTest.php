<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TaskApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_create_task()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user, 'sanctum')
                         ->postJson('/api/v1/tasks', [
                             'task_number' => 'TSK-001',
                             'title' => 'Setup Database Index Strategy',
                             'status' => 'TODO',
                             'priority' => 'HIGH',
                             'estimated_hours' => 8.0,
                         ]);

        $response->assertStatus(201)
                 ->assertJsonPath('data.task_number', 'TSK-001');
    }
}
