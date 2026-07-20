<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SystemIntegrationApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_public_user_can_fetch_openapi_spec()
    {
        $response = $this->getJson('/api/v1/docs/openapi.json');

        $response->assertStatus(200)
                 ->assertJsonPath('openapi', '3.1.0');
    }

    public function test_admin_can_register_api_client()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user, 'sanctum')
                         ->postJson('/api/v1/admin/api-clients', [
                             'client_name' => 'World Bank M&E Gateway',
                             'rate_limit' => 2000,
                         ]);

        $response->assertStatus(201)
                 ->assertJsonPath('data.client.client_name', 'World Bank M&E Gateway');
    }
}
