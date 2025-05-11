<?php

namespace App\Http\Controllers\Api\Gif;

use App\Http\Controllers\Controller;
use App\Http\Requests\Gif\SaveFavoriteGifRequest;
use App\Http\Resources\FavoriteResource;
use App\Repositories\Contracts\FavoriteRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class FavoriteController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(SaveFavoriteGifRequest $request, string $id, FavoriteRepositoryInterface $favoriteRepository): JsonResponse
    {
        $fav = $favoriteRepository->save(
            $request->user()->id,
            $id,
            $request->input('alias')
        );

        return FavoriteResource::make($fav)
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }
}
