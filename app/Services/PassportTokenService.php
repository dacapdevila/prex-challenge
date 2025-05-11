<?php

namespace App\Services;

use Illuminate\Http\Request;

class PassportTokenService
{
    public function getToken(string $email, string $password): array
    {
        $request = Request::create('/oauth/token', 'POST', [
            'grant_type' => 'password',
            'client_id' => config('services.passport.client_id'),
            'client_secret' => config('services.passport.client_secret'),
            'username' => $email,
            'password' => $password,
        ]);

        $response = app()->handle($request);

        return json_decode($response->getContent(), true);
    }
}
