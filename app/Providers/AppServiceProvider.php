<?php

namespace App\Providers;

use App\Repositories\Contracts\FavoriteRepositoryInterface;
use App\Repositories\Contracts\GifRepositoryInterface;
use App\Repositories\EloquentFavoriteRepository;
use App\Repositories\Giphy\GifRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(GifRepositoryInterface::class, GifRepository::class);
        $this->app->bind(FavoriteRepositoryInterface::class, EloquentFavoriteRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
