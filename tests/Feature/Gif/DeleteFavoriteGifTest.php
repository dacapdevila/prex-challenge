<?php

namespace Tests\Feature\Gif;

use App\Models\Favorite;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Passport\Passport;
use Tests\TestCase;

class DeleteFavoriteGifTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_delete_favorite_gif(): void
    {
        $user = User::factory()->create();
        $favorite = Favorite::factory()->create(['user_id' => $user->id]);

        Passport::actingAs($user);

        $this->deleteJson("/api/user/favorites/{$favorite->id}")
            ->assertNoContent();

        $this->assertDatabaseMissing('favorites', ['id' => $favorite->id]);
    }

    public function test_cannot_delete_other_users_favorite(): void
    {
        $user = User::factory()->create();
        $other = User::factory()->create();
        $favorite = Favorite::factory()->create(['user_id' => $other->id]);

        Passport::actingAs($user);

        $this->deleteJson("/api/user/favorites/{$favorite->id}")
            ->assertForbidden();

        $this->assertDatabaseHas('favorites', ['id' => $favorite->id]);
    }
}
