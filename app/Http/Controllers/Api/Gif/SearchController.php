<?php

namespace App\Http\Controllers\Api\Gif;

use App\Http\Controllers\Controller;
use App\Http\Requests\Gif\SearchGifRequest;
use App\Repositories\Contracts\GifRepositoryInterface;
use Illuminate\Http\JsonResponse;

class SearchController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(SearchGifRequest $request, GifRepositoryInterface $repo): JsonResponse
    {
        $data = $repo->search(
            $request->input('query'),
            (int) $request->integer('limit', 25),
            (int) $request->integer('offset', 0),
        );

        return response()->json($data, 200);
    }
}
