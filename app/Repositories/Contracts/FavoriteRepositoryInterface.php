<?php

namespace App\Repositories\Contracts;

use App\Models\Favorite;

interface FavoriteRepositoryInterface
{
    public function save(int $userId, string $gifId, string $alias): Favorite;
}
