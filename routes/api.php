<?php

use App\Http\Controllers\BetController;
use App\Http\Controllers\GameMatchController;
use App\Http\Controllers\SportController;
use App\Http\Controllers\TeamController;
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

// Routes publiques
Route::prefix('sports')->group(function () {
    Route::get('/', [SportController::class, 'index']);
    Route::get('/{id}', [SportController::class, 'show']);
});

Route::prefix('teams')->group(function () {
    Route::get('/', [TeamController::class, 'index']);
    Route::get('/{id}', [TeamController::class, 'show']);
});

Route::prefix('matches')->group(function () {
    Route::get('/', [GameMatchController::class, 'index']);
    Route::get('/upcoming', [GameMatchController::class, 'upcoming']);
    Route::get('/popular', [GameMatchController::class, 'popular']);
    Route::get('/{id}', [GameMatchController::class, 'show']);
});

// Routes protégées (nécessitent une authentification)
Route::middleware('auth:sanctum')->group(function () {
    Route::prefix('bets')->group(function () {
        Route::get('/', [BetController::class, 'index']);
        Route::post('/', [BetController::class, 'store']);
        Route::get('/{id}', [BetController::class, 'show']);
    });
});