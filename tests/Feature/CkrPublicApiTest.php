<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\CkrCategory;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CkrPublicApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_public_user_can_fetch_ckr_categories()
    {
        CkrCategory::create([
            'slug' => 'agro-tech',
            'name' => 'Agro-Industrial Technology',
            'description' => 'Technical reports on agro-processing infrastructure.',
        ]);

        $response = $this->getJson('/api/v1/ckr/categories');

        $response->assertStatus(200)
                 ->assertJson(['success' => true]);
    }
}
