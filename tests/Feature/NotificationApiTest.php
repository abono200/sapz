<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class NotificationApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_fetch_notifications()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user, 'sanctum')
                         ->getJson('/api/v1/notifications');

        $response->assertStatus(200)
                 ->assertJson(['success' => true]);
    }
}
