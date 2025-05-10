<?php

namespace Tests\Feature\Auth;

use Database\Seeders\OauthClientSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class RegisterControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(OauthClientSeeder::class);

        $client = DB::table('oauth_clients')->where('name', 'Password Grant Client')->first();
        config(['services.passport.client_id' => $client->id]);
        config(['services.passport.client_secret' => $client->secret]);
    }

    public function test_user_can_register()
    {
        $response = $this->postJson('/api/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertCreated()->assertJsonStructure(['data' => ['token_type', 'access_token', 'user']]);
    }

    public function test_register_requires_validation()
    {
        $response = $this->postJson('/api/register', []);

        $response->assertStatus(422)->assertJsonValidationErrors(['name', 'email', 'password']);
    }
}
