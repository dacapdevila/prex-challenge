<?php

namespace Tests\Unit\Gif;

use App\Data\DTO\GifDTO;
use App\Data\DTO\PaginationDTO;
use App\Repositories\Contracts\GifRepositoryInterface;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class GifRepositoryTest extends TestCase
{
    public function test_repository_maps_json_to_dto(): void
    {
        Http::fake([
            '*api.giphy.com/*' => Http::response([
                'data' => [
                    [
                        'id' => 'abc',
                        'url' => 'https://giphy.com/gifs/abc',
                        'title' => 'Funny Cat',
                        'images' => ['preview_gif' => ['url' => 'https://media.giphy.com/abc.gif']],
                    ],
                ],
                'pagination' => ['total_count' => 100, 'count' => 1, 'offset' => 0],
                'meta' => ['status' => 200],
            ], 200),
        ]);

        $repo = app(GifRepositoryInterface::class);
        $result = $repo->search('cat', 1, 0);

        $this->assertCount(1, $result['gifs']);
        $this->assertInstanceOf(GifDTO::class, $result['gifs'][0]);
        $this->assertEquals('abc', $result['gifs'][0]->id);

        $this->assertInstanceOf(PaginationDTO::class, $result['pagination']);
        $this->assertEquals(1, $result['pagination']->count);
    }
}
