<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class GetTaskById extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);
        //GETTING TASK FORM TASK TABLE OF ID 1
        $this->getJson('/api/tasks/1')
            ->assertStatus(200)
            ->assertJsonStructure(['status', 'message',]);

        //GETTING TASK FORM TASK TABLE OF ID 2
        $this->getJson('/api/tasks/2')
            ->assertStatus(200)
            ->assertJsonStructure(['status', 'message',]);
    }
}
