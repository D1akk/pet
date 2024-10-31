<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_register()
    {
        $response = $this->postJson('/api/register', [
            'name' => 'test',
            'email' => 'test@test.test',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);
    
        $response->assertStatus(201)
                 ->assertJsonStructure([
                     'user' => [
                         'name',
                         'email',
                         'updated_at',
                         'created_at',
                         'id',
                     ],
                     'token',
                 ]);
    }

    public function test_user_can_login()
    {
        $user = User::create([
            'name' => 'test',
            'email' => 'test@test.test',
            'password' => bcrypt('password'),
        ]);

        $response = $this->postJson('/api/login', [
            'email' => 'test@test.test',
            'password' => 'password',
        ]);

        $response->assertStatus(200)
                 ->assertJsonStructure(['token']);
    }

    public function test_user_can_get_authenticated_user()
    {
        $user = User::create([
            'name' => 'test',
            'email' => 'test@test.test',
            'password' => bcrypt('password'),
        ]);

        $token = \Tymon\JWTAuth\Facades\JWTAuth::fromUser($user);

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $token])
                         ->getJson('/api/user');

        $response->assertStatus(200)
                 ->assertJson(['name' => 'test']);
    }

    public function test_user_can_logout()
    {
        $user = User::create([
            'name' => 'test',
            'email' => 'test@test.test',
            'password' => bcrypt('password'),
        ]);

        $token = \Tymon\JWTAuth\Facades\JWTAuth::fromUser($user);

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $token])
                         ->postJson('/api/logout');

        $response->assertStatus(200)
                 ->assertJson(['message' => 'Successfully logged out']);
    }
}
