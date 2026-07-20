<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProgrammeApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_create_programme()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user, 'sanctum')
                         ->postJson('/api/v1/programmes', [
                             'code' => 'SAPZ-PHASE-1',
                             'name' => 'Special Agro-Industrial Processing Zone Phase I',
                             'funder' => 'IFAD / AfDB',
                             'total_allocation' => 250000000.00,
                             'status' => 'ACTIVE',
                         ]);

        $response->assertStatus(201)
                 ->assertJsonPath('data.code', 'SAPZ-PHASE-1');
    }
}
