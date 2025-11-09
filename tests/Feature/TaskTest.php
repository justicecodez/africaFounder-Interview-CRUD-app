<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TaskTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $user = User::factory()->create();
        $token = $user->createToken('test')->plainTextToken;

        //CREATING TASK IN TASK TABLE
        $this->withHeader('Authorization', "Bearer $token")
            ->postJson('/api/tasks', ['title' => 'Task 1', 'description' => 'desc 1', 'status'=>"pending", 'user_id'=>$user->id])
            ->assertStatus(201)
            ->assertJsonFragment(['title' => 'Task 1']);

        $this->withHeader('Authorization', "Bearer $token")
            ->postJson('/api/tasks', ['title' => 'Task 2', 'description' => 'desc 2', 'status'=>"completed", 'user_id'=>$user->id])
            ->assertStatus(201)
            ->assertJsonFragment(['title' => 'Task 2']);

        $this->withHeader('Authorization', "Bearer $token")
            ->postJson('/api/tasks', ['title' => 'Task 3', 'description' => 'desc 3', 'status'=>"in-progress", 'user_id'=>$user->id])
            ->assertStatus(201)
            ->assertJsonFragment(['title' => 'Task 3']);

            //GETING TASK FROM TASK TABLE
        $this->withHeader('Authorization', "Bearer $token")
            ->getJson('/api/tasks')
            ->assertStatus(200)
            ->assertJsonStructure(['status', 'message', 'meta', 'link']);

            //GETTING TASK FORM TASK TABLE OF ID 1
        $this->withHeader('Authorization', "Bearer $token")
            ->getJson('/api/tasks/1')
            ->assertStatus(200)
            ->assertJsonStructure(['status', 'message',]);

            //UPDATING TASK TABLE OF ID 1
        $this->withHeader('Authorization', "Bearer $token")
            ->put('/api/tasks/1',['description'=>'description changed'])
            ->assertStatus(201)
            ->assertJsonStructure(['status', 'message']);

            //UPDATING TASK TABLE OF ID 2
        $this->withHeader('Authorization', "Bearer $token")
            ->put('/api/tasks/2',['title'=>'title changed'])
            ->assertStatus(201)
            ->assertJsonStructure(['status', 'message']);

            //DELETE TASK OF ID 1 FROM TASK TABLE
        $this->withHeader('Authorization', "Bearer $token")
            ->delete('/api/tasks/1')
            ->assertStatus(200)
            ->assertJsonStructure(['status', 'message',]);
    }
}
