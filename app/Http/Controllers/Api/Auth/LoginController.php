<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Resources\Auth\LoginResource;
use App\Services\PassportTokenService;
use Exception;
use Illuminate\Http\JsonResponse;

class LoginController extends Controller
{
    public function __construct(private readonly PassportTokenService $passportTokenService) {}

    /**
     * Handle the incoming request.
     *
     * @throws Exception
     */
    public function __invoke(LoginRequest $request): JsonResponse|LoginResource
    {
        if (! auth()->attempt($request->only('email', 'password'))) {
            return response()->json([
                'message' => 'Invalid credentials',
            ], 401);
        }

        $user = auth()->user();

        $token = $this->passportTokenService->getToken($request->email, $request->password);

        return new LoginResource($token, $user);
    }
}
