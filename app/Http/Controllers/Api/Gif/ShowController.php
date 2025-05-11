<?php

namespace App\Http\Controllers\Api\Gif;

use App\Data\DTO\GifDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Gif\ShowGifRequest;
use App\Repositories\Contracts\GifRepositoryInterface;

class ShowController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(ShowGifRequest $request, GifRepositoryInterface $repo): GifDTO
    {
        return $repo->find($request->id);
    }
}
