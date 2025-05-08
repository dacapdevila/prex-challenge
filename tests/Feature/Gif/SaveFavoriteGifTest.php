<?php

namespace Tests\Feature\Gif;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Passport\Passport;
use Tests\TestCase;

class SaveFavoriteGifTest extends TestCase
{
    use RefreshDatabase;

    public function test_requires_authentication(): void
    {
        $response = $this->postJson('/api/gifs/123/favorite', [
            'alias' => 'Mi favorito',
        ]);

        $response->assertUnauthorized();
    }

    public function test_alias_is_required(): void
    {
        $user = User::factory()->create();
        Passport::actingAs($user);

        $response = $this->postJson('/api/gifs/123/favorite', []);

        $response->assertStatus(422)
            ->assertJsonValidationErrors('alias');
    }

    public function test_can_save_favorite_gif(): void
    {
        $user = User::factory()->create();
        Passport::actingAs($user);

        $response = $this->postJson('/api/gifs/1234/favorite', [
            'alias' => 'Gato divertido',
        ]);

        $response->assertCreated()
            ->assertJsonStructure([
                'id',
                'user_id',
                'gif_id',
                'alias',
                'created_at',
            ])
            ->assertJsonFragment([
                'user_id' => $user->id,
                'gif_id' => '1234',
                'alias' => 'Gato divertido',
            ]);

        $this->assertDatabaseHas('favorites', [
            'user_id' => $user->id,
            'gif_id' => '1234',
            'alias' => 'Gato divertido',
        ]);
    }
}
