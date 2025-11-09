<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->postJson('/api/register', [
            'name'=>'Test','email'=>'test@example.com','password'=>'Afrifounder1234()',
        ]);

        $response->assertStatus(201)->assertJsonStructure(['user','token']);

        $response = $this->postJson('/api/login', ['email'=>'test@example.com','password'=>'Afrifounder1234()']);
        $response->assertStatus(200)->assertJsonStructure(['user','token']);
    }
}
