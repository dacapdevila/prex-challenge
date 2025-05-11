<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;

class ExternalApiException extends Exception
{
    public function render($request): JsonResponse
    {
        return response()->json([
            'message' => $this->getMessage(),
        ], 502);
    }
}
