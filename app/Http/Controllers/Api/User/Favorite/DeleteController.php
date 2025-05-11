<?php

namespace App\Http\Controllers\Api\User\Favorite;

use App\Http\Controllers\Controller;
use App\Repositories\EloquentFavoriteRepository;
use Illuminate\Http\JsonResponse;

class DeleteController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke($id, EloquentFavoriteRepository $favorites): JsonResponse
    {
        $favorites->delete($id);

        return response()->json(['message' => 'Favorite deleted successfully']);
    }
}
