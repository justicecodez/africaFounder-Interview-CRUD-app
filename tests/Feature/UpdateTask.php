<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class UpdateTask extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);
        //UPDATING TASK TABLE OF ID 1
        $this->put('/api/tasks/1',['description'=>'description changed'])
            ->assertStatus(201)
            ->assertJsonStructure(['status', 'message']);

            //UPDATING TASK TABLE OF ID 2
        $this->put('/api/tasks/2',['title'=>'title changed'])
            ->assertStatus(201)
            ->assertJsonStructure(['status', 'message']);
    }
}
