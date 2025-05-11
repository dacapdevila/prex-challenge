<?php

namespace App\Repositories\Giphy;

use App\Data\DTO\GifDTO;
use App\Data\DTO\PaginationDTO;
use App\Exceptions\ExternalApiException;
use App\Repositories\Contracts\GifRepositoryInterface;
use App\Services\GiphyService;

class GifRepository implements GifRepositoryInterface
{
    public function __construct(private readonly GiphyService $giphy) {}

    /**
     * @throws ExternalApiException
     */
    public function search(string $query, int $limit, int $offset): array
    {
        $json = $this->giphy->search($query, $limit, $offset);

        $gifs = collect($json['data'])
            ->map(fn ($g) => new GifDTO(
                $g['id'],
                $g['url'],
                $g['title'] ?? '',
                $g['images']['preview_gif']['url'] ?? '',
            ))
//            ->map(fn (GifDTO $dto) => $dto->jsonSerialize())
            ->all();

        $p = $json['pagination'];
        $pagination = new PaginationDTO($p['total_count'], $p['count'], $p['offset']);

        return [
            'gifs' => $gifs,
            'pagination' => $pagination,
        ];
    }

    /**
     * @throws ExternalApiException
     */
    public function find(string $id): GifDTO
    {
        $g = $this->giphy->show($id)['data'];

        return new GifDTO(
            $g['id'], $g['url'],
            $g['title'] ?? '', $g['images']['preview_gif']['url'] ?? ''
        );
    }
}
