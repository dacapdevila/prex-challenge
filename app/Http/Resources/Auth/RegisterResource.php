<?php

namespace App\Http\Resources\Auth;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RegisterResource extends JsonResource
{
    protected $token;

    protected $user;

    public function __construct($token, $user)
    {
        parent::__construct(null);
        $this->token = $token;
        $this->user = $user;
    }

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'message' => 'Successfully registered',
            'user' => [
                'id' => $this->user->id,
                'name' => $this->user->name,
                'email' => $this->user->email,
            ],
            'token_type' => $this->token['token_type'],
            'expires_in' => $this->token['expires_in'],
            'access_token' => $this->token['access_token'],
            'refresh_token' => $this->token['refresh_token'],
        ];
    }

    public function withResponse($request, $response): void
    {
        $response->setStatusCode(201);
    }
}
