<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DocumentRegistryApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_register_document()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user, 'sanctum')
                         ->postJson('/api/v1/documents', [
                             'reference_number' => 'SAPZ-DOC-2026-001',
                             'title' => 'SAPZ Technical Engineering Manual',
                             'category' => 'TECHNICAL',
                             'security_classification' => 'RESTRICTED',
                         ]);

        $response->assertStatus(201)
                 ->assertJsonPath('data.reference_number', 'SAPZ-DOC-2026-001');
    }
}
