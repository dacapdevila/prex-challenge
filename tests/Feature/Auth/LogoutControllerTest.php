<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Passport\ClientRepository;
use Tests\TestCase;

class LogoutControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_logout()
    {
        $user = User::factory()->create([
            'password' => bcrypt('secret'),
        ]);

        $clientRepository = new ClientRepository;
        $client = $clientRepository->createPasswordGrantClient(null, 'Test Password Grant', config('app.url'));

        $response = $this->postJson('/oauth/token', [
            'grant_type' => 'password',
            'client_id' => $client->id,
            'client_secret' => $client->secret,
            'username' => $user->email,
            'password' => 'secret',
        ]);

        $token = $response->json('access_token');

        $this->assertNotNull($token, 'Failed to get access_token from /oauth/token');

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->postJson('/api/logout');

        $response->assertOk()
            ->assertJson([
                'message' => 'Successfully logged out',
            ]);
    }
}
