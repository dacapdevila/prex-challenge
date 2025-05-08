<?php

namespace Tests\Feature\Gif;

use App\Models\User;
use Illuminate\Support\Facades\Http;
use Laravel\Passport\Passport;
use Tests\TestCase;

class ShowGifTest extends TestCase
{
    public function test_show_returns_expected_structure(): void
    {
        Passport::actingAs(User::factory()->create());

        Http::fake([
            'https://api.giphy.com/v1/gifs/abc' => Http::response([
                'data' => [
                    'id' => 'abc',
                    'url' => 'https://giphy.com/gifs/abc',
                    'title' => 'Funny Cat',
                    'images' => [
                        'preview_gif' => ['url' => 'https://media.giphy.com/abc.gif'],
                    ],
                ],
                'meta' => ['status' => 200],
            ], 200),
        ]);

        $response = $this->getJson('/api/gifs/abc');

        $response->assertOk()
            ->assertJsonStructure([
                'id',
                'url',
                'title',
                'preview',
            ])
            ->assertJson([
                'id' => 'abc',
                'preview' => 'https://media.giphy.com/abc.gif',
            ]);

        Http::assertSent(function ($request) {
            return $request->url() === 'https://api.giphy.com/v1/gifs/abc'
                && $request->method() === 'GET';
        });
    }

    public function test_giphy_failure_returns_502(): void
    {
        Passport::actingAs(User::factory()->create());

        Http::fake([
            'https://api.giphy.com/v1/gifs/abc' => Http::response(['message' => 'Service down'], 503),
        ]);

        $this->getJson('/api/gifs/abc')
            ->assertStatus(502)
            ->assertJson(['message' => 'Giphy error: 503']);
    }
}
