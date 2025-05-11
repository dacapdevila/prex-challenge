<?php

namespace App\Repositories\Contracts;

use App\Models\Favorite;

interface FavoriteRepositoryInterface
{
    public function save(int $userId, string $gifId, string $alias): Favorite;

    public function listByUser(int $userId);

    public function delete(int $id);
}
