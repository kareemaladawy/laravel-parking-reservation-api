<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function testUserCanLoginWithCorrectCredintials()
    {
        $user = User::factory()->create();

        $response = $this->postJson('api/v1/auth/login', [
            'email' => $user->email,
            'password' => 'password'
        ]);

        $response->assertStatus(201);
    }

    public function testUserCannotLoginWithIncorrectCredintials()
    {
        $user = User::factory()->create();

        $response = $this->postJson('api/v1/auth/login', [
            'email' => $user->email,
            'password' => 'wrong_password'
        ]);

        $response->assertStatus(422);
    }

    public function testUserCanRegisterWithCorrectCredintials()
    {
        $response = $this->postJson('api/v1/auth/register', [
            'name' => 'Kareem Aladawy',
            'email' => 'kareem@aladawy.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertStatus(201)
            ->assertJsonStructure(['access_token',]);

        $this->assertDatabaseHas('users', [
            'name' => 'Kareem Aladawy',
            'email' => 'kareem@aladawy.com'
        ]);
    }

    public function testUserCannotRegisterWithIncorrectCredintials()
    {
        $response = $this->postJson('api/v1/auth/register', [
            'name' => 'Ka',
            'email' => 'kareem@aladawy.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertStatus(422);

        $this->assertDatabaseMissing('users', [
            'name' => 'Ka',
            'email' => 'kareem@aladawy.com'
        ]);
    }

    public function testUserCanLogout()
    {
        $user = User::factory()->create();

        $response = $this->postJson('api/v1/auth/login', [
            'email' => $user->email,
            'password' => 'password'
        ]);

        $response->assertStatus(201);

        $logout_response = $this->actingAs($user)->post('/api/v1/auth/logout');

        $logout_response->assertNoContent();
    }

}
