<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ExecutiveDashboardApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_executive_can_fetch_dashboard_summary()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user, 'sanctum')
                         ->getJson('/api/v1/executive/summary');

        $response->assertStatus(200)
                 ->assertJson([
                     'success' => true,
                     'data' => [
                         'system_status' => 'OPERATIONAL'
                     ]
                 ]);
    }
}
