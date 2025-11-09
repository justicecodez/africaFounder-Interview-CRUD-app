<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class DeleteTask extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);
        //DELETE TASK OF ID 1 FROM TASK TABLE
        $this->delete('/api/tasks/1')
            ->assertStatus(200)
            ->assertJsonStructure(['status', 'data',]);
    }
}
