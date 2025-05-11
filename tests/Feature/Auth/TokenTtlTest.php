<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Passport\ClientRepository;
use Laravel\Passport\Passport;
use Tests\TestCase;

class TokenTtlTest extends TestCase
{
    use RefreshDatabase;

    public function test_password_grant_returns_30_min_expiry(): void
    {
        $user = User::factory()->create(['password' => bcrypt('secret')]);

        $repo = app(ClientRepository::class);
        $client = $repo->createPasswordGrantClient(
            null,
            'Test Password Grant Client',
            ''
        );

        Passport::tokensExpireIn(now()->addMinutes(30));

        $response = $this->postJson('/oauth/token', [
            'grant_type' => 'password',
            'client_id' => $client->id,
            'client_secret' => $client->secret,
            'username' => $user->email,
            'password' => 'secret',
        ]);

        $response->assertOk()
            ->assertJsonPath('expires_in', 30 * 60)
            ->assertJsonStructure(['access_token', 'token_type', 'expires_in']);
    }
}
