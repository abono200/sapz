<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Workflow;
use Illuminate\Foundation\Testing\RefreshDatabase;

class WorkflowApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_create_workflow_template()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user, 'sanctum')
                         ->postJson('/api/v1/workflows', [
                             'code' => 'WF-DOC-APPROVAL',
                             'name' => 'Standard Executive Document Approval',
                             'steps' => [
                                 ['step_order' => 1, 'name' => 'Technical Review'],
                                 ['step_order' => 2, 'name' => 'Director Approval'],
                             ]
                         ]);

        $response->assertStatus(201)
                 ->assertJsonPath('data.code', 'WF-DOC-APPROVAL');
    }
}
