<?php

namespace Tests\Unit\Passport;

use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class PassportTokenService extends TestCase
{
    public function test_generate_token_returns_data()
    {
        Http::fake([
            '*' => Http::response(['access_token' => 'fake-token', 'token_type' => 'Bearer'], 200),
        ]);

        $service = new PassportTokenService;
        $response = $service->getToken('email@example.com', 'password');

        $this->assertEquals('fake-token', $response['access_token']);
    }
}
