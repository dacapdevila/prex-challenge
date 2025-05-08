<?php

use App\Http\Controllers\Api\Gif\FavoriteController;
use App\Http\Controllers\Api\Gif\SearchController;
use App\Http\Controllers\Api\Gif\ShowController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware(['auth:api'])->prefix('gifs')->group(function () {
    Route::get('/', SearchController::class);
    Route::get('/{id}', ShowController::class);
    Route::post('/{id}/favorite', FavoriteController::class);
});
