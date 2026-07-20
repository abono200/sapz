<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MobileSyncApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_mobile_device_can_batch_sync_inspections()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user, 'sanctum')
                         ->postJson('/api/v1/mobile/sync', [
                             'device_id' => 'MOB-DEVICE-771',
                             'inspections' => [],
                         ]);

        $response->assertStatus(201)
                 ->assertJsonPath('data.device_id', 'MOB-DEVICE-771');
    }
}
