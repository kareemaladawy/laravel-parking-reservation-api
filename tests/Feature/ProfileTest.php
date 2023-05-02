<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProfileTest extends TestCase
{
    use RefreshDatabase;

    public function testUserCanGetTheirProfile()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/api/v1/profile');

        $response->assertStatus(200)
            ->assertJsonCount(2)
            ->assertJsonStructure(['name', 'email']);
    }

    public function testUserCannotGetTheirProfileIfTheyAreNotAuthenticated()
    {
        $response = $this->withHeaders([
                'Accept' => 'application/json',
            ])
            ->get('/api/v1/profile');

        $response->assertStatus(401);
    }

    public function testUserCanUpdateTheirProfileWithCorrectCredentials()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->putJson('/api/v1/profile', [
            'name' => 'updated name',
            'email' => 'updated@email.com'
        ]);

        $response->assertStatus(202)
            ->assertJsonCount(2)
            ->assertJsonStructure(['name', 'email'])
            ->assertJsonFragment(['name' => 'updated name']);

        $this->assertDatabaseHas('users', [
            'name' => 'updated name',
            'email' => 'updated@email.com'
        ]);
    }

    public function testUserCannotUpdateTheirProfileWithIncorrectCredentials()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->putJson('/api/v1/profile', [
            'name' => 'na',
            'email' => 'updated@email.com'
        ]);

        $response->assertStatus(422);
    }

    public function testUserCanChangeTheirPassword()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->putJson('/api/v1/password', [
            'current_password' => 'password',
            'password' => 'new_password',
            'password_confirmation' => 'new_password',
        ]);

        $response->assertStatus(202)
            ->assertJsonCount(1)
            ->assertJsonStructure(['message']);
    }

    public function testUserCannotChangeTheirPasswordWithIncorrectFormat()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->putJson('/api/v1/password', [
            'current_password' => 'password',
            'password' => 'p',
            'password_confirmation' => 'p',
        ]);

        $response->assertStatus(422);
    }

}
