<?php

namespace Tests\Feature\Gif;

use App\Models\Favorite;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Passport\Passport;
use Tests\TestCase;

class ListFavoriteGifTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_list_favorites(): void
    {
        $user = User::factory()->create();

        Favorite::factory()->count(3)->create([
            'user_id' => $user->id,
            'gif_id' => 1,
            'alias' => 'My favorite gif',
        ]);
        Favorite::factory()->count(2)->create();

        Passport::actingAs($user);

        $this->getJson('/api/user/favorites')
            ->assertOk()
            ->assertJsonCount(3, 'data');
    }

    public function test_requires_authentication(): void
    {
        $this->getJson('/api/user/favorites')
            ->assertUnauthorized();
    }
}
