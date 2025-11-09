<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class GetAllTask extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        // GETING TASK FROM TASK TABLE
        $this->getJson('/api/tasks')
            ->assertStatus(200)
            ->assertJsonStructure(['status', 'data', 'meta', 'links']);
    }
}
