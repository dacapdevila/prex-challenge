<?php

namespace Tests\Feature\Gif;

use App\Models\User;
use Illuminate\Support\Facades\Http;
use Laravel\Passport\Passport;
use Tests\TestCase;

class SearchGifTest extends TestCase
{
    public function test_search_returns_expected_structure(): void
    {
        Passport::actingAs(User::factory()->create());

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
                'pagination' => ['total_count' => 999, 'count' => 1, 'offset' => 0],
                'meta' => ['status' => 200],
            ], 200),
        ]);

        $resp = $this->getJson('/api/gifs?query=cat&limit=1');

        $resp->assertOk()
            ->assertJsonStructure([
                'gifs' => [
                    ['id', 'url', 'title', 'preview'],
                ],
                'pagination' => ['total', 'count', 'offset'],
            ])
            ->assertJsonPath('gifs.0.id', 'abc')
            ->assertJsonPath('pagination.count', 1);

        Http::assertSent(function ($request) {
            return $request->url() === 'https://api.giphy.com/v1/gifs/search'
                && $request['q'] === 'cat'
                && $request['limit'] == 1;
        });
    }

    public function test_query_is_required(): void
    {
        Passport::actingAs(User::factory()->create());

        $this->getJson('/api/gifs')
            ->assertStatus(422)
            ->assertJsonValidationErrors('query');
    }

    public function test_giphy_failure_returns_502(): void
    {
        Passport::actingAs(User::factory()->create());

        Http::fake([
            'api.giphy.com/*' => Http::response(['message' => 'Service down'], 503),
        ]);

        $this->getJson('/api/gifs?query=cat')
            ->assertStatus(502)
            ->assertJson(['message' => 'Giphy error: 503']);
    }
}
