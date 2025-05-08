<?php

namespace App\Repositories;

use App\Models\Favorite;
use App\Repositories\Contracts\FavoriteRepositoryInterface;

class EloquentFavoriteRepository implements FavoriteRepositoryInterface
{
    public function save(int $userId, string $gifId, string $alias): Favorite
    {
        return Favorite::create([
            'user_id' => $userId,
            'gif_id' => $gifId,
            'alias' => $alias,
        ]);
    }
}
