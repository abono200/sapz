<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AiSearchApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_perform_semantic_search()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user, 'sanctum')
                         ->getJson('/api/v1/search/semantic?query=procurement');

        $response->assertStatus(200)
                 ->assertJson(['success' => true]);
    }

    public function test_user_can_chat_with_ai_assistant()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user, 'sanctum')
                         ->postJson('/api/v1/ai/assistant/chat', [
                             'prompt' => 'Summarize the SAPZ procurement requirements',
                         ]);

        $response->assertStatus(201)
                 ->assertJsonPath('success', true);
    }
}
