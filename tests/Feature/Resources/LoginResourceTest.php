<?php

namespace Tests\Feature\Resources;

use App\Http\Resources\Auth\LoginResource;
use App\Models\User;
use Tests\TestCase;

class LoginResourceTest extends TestCase
{
    public function test_login_resource_returns_expected_data()
    {
        $user = User::factory()->make();
        $token = [
            'token_type' => 'Bearer',
            'expires_in' => 1800,
            'access_token' => 'some-access-token',
            'refresh_token' => 'some-refresh-token',
        ];

        $resource = new LoginResource($token, $user);
        $response = $resource->toArray(request());

        $this->assertArrayHasKey('token_type', $response);
        $this->assertArrayHasKey('expires_in', $response);
        $this->assertArrayHasKey('access_token', $response);
        $this->assertArrayHasKey('refresh_token', $response);
        $this->assertArrayHasKey('user', $response);
    }
}
