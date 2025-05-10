<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Database\Seeders\OauthClientSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class LoginControllerTest extends TestCase
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

    public function test_user_can_login_successfully()
    {
        $user = User::factory()->create(['password' => bcrypt('secret')]);

        $response = $this->postJson('/api/login', [
            'email' => $user->email,
            'password' => 'secret',
        ]);

        $response->assertOk()->assertJsonStructure(['data' => ['token_type', 'access_token', 'user']]);
    }

    public function test_user_cannot_login_with_invalid_credentials()
    {
        $response = $this->postJson('/api/login', [
            'email' => 'invalid@example.com',
            'password' => 'wrongpass',
        ]);

        $response->assertStatus(401);
    }
}
