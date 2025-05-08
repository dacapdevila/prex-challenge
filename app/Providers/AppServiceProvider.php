<?php

namespace App\Providers;

use App\Repositories\Contracts\AuditLogRepositoryInterface;
use App\Repositories\Contracts\FavoriteRepositoryInterface;
use App\Repositories\Contracts\GifRepositoryInterface;
use App\Repositories\EloquentAuditLogRepository;
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
        $this->app->bind(AuditLogRepositoryInterface::class, EloquentAuditLogRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
