<?php

namespace App\Repositories;

use App\Models\Favorite;
use App\Repositories\Contracts\FavoriteRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

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

    public function listByUser(int $userId): LengthAwarePaginator
    {
        return Favorite::where('user_id', $userId)->paginate(10);
    }

    public function delete(int $id): void
    {
        Favorite::findOrFail($id)->delete();
    }
}
