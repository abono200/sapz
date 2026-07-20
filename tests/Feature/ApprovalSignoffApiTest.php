<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\ApprovalRequest;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ApprovalSignoffApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_fetch_approval_inbox()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user, 'sanctum')
                         ->getJson('/api/v1/approvals/inbox');

        $response->assertStatus(200)
                 ->assertJson(['success' => true]);
    }
}
