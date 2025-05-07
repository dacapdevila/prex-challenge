<?php

namespace App\Repositories\Contracts;

use App\Data\DTO\GifDTO;
use App\Data\DTO\PaginationDTO;

interface GifRepositoryInterface
{
    /** @return array{gifs: GifDTO[], pagination: PaginationDTO} */
    public function search(string $query, int $limit, int $offset): array;

    public function find(string $id): GifDTO;
}
