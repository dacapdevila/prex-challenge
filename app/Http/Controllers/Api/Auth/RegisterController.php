<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\Auth\RegisterResource;
use App\Models\User;
use App\Services\PassportTokenService;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function __construct(private readonly PassportTokenService $passportTokenService) {}

    /**
     * Handle the incoming request.
     */
    public function __invoke(RegisterRequest $request): RegisterResource
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $token = $this->passportTokenService->getToken($request->email, $request->password);

        return new RegisterResource($token, $user);
    }
}
