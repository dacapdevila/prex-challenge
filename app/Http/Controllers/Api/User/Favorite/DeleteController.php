<?php

namespace App\Http\Controllers\Api\User\Favorite;

use App\Http\Controllers\Controller;
use App\Repositories\EloquentFavoriteRepository;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Response;

class DeleteController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @throws AuthorizationException
     */
    public function __invoke($id, EloquentFavoriteRepository $favorites): Response
    {
        $favorite = $favorites->find($id);

        $this->authorize('delete', $favorite);

        $favorites->delete($id);

        return response()->noContent();
    }
}
