<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class CreateTask extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);
        //CREATING TASK IN TASK TABLE
        $this->postJson('/api/tasks', ['title' => 'Task 1', 'description' => 'desc 1', 'status'=>"pending", 'user_id'=>$user->id])
            ->assertStatus(201)
            ->assertJsonFragment(['title' => 'Task 1']);

        $this->postJson('/api/tasks', ['title' => 'Task 2', 'description' => 'desc 2', 'status'=>"completed", 'user_id'=>$user->id])
            ->assertStatus(201)
            ->assertJsonFragment(['title' => 'Task 2']);

        $this->postJson('/api/tasks', ['title' => 'Task 3', 'description' => 'desc 3', 'status'=>"in-progress", 'user_id'=>$user->id])
            ->assertStatus(201)
            ->assertJsonFragment(['title' => 'Task 3']);
    }
}
