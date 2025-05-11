<?php

namespace App\Http\Controllers\Api\User\Favorite;

use App\Http\Controllers\Controller;
use App\Http\Resources\FavoriteResource;
use App\Repositories\EloquentFavoriteRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ListController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, EloquentFavoriteRepository $favorites): AnonymousResourceCollection
    {
        $items = $favorites->listByUser($request->user()->id);

        return FavoriteResource::collection($items);
    }
}
