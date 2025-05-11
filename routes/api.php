<?php

use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\LogoutController;
use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\Api\Gif\FavoriteController;
use App\Http\Controllers\Api\Gif\SearchController;
use App\Http\Controllers\Api\Gif\ShowController;
use App\Http\Controllers\Api\User\Favorite\DeleteController;
use App\Http\Controllers\Api\User\Favorite\ListController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/login', LoginController::class);
Route::post('/register', RegisterController::class);
Route::middleware(['auth:api', 'audit'])->post('/logout', LogoutController::class);

Route::middleware(['auth:api', 'audit'])->prefix('gifs')->group(function () {
    Route::get('/', SearchController::class);
    Route::get('/{id}', ShowController::class);
    Route::post('/{id}/favorite', FavoriteController::class);
});

Route::middleware(['auth:api', 'audit'])->prefix('user/favorites')->group(function () {
    Route::get('/', ListController::class);
    Route::delete('/{id}', DeleteController::class);
});
