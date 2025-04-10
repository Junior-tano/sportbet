<?php

use App\Http\Controllers\GameMatchController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/', function () {
    // Récupérer les matchs depuis le contrôleur pour la page d'accueil
    $matchController = app(GameMatchController::class);
    $matches = $matchController->index();
    
    // Convertir les données en JSON correctement formaté
    $matchesJson = json_encode($matches);
    
    return view('sportsbet2.index', ['matchesJson' => $matchesJson]);
})->name('home');

Route::get('/matches', function () {
    // Récupérer les matchs depuis le contrôleur
    $matchController = app(GameMatchController::class);
    $matches = $matchController->index();
    
    // Convertir les données en JSON correctement formaté
    $matchesJson = json_encode($matches);
    
    return view('sportsbet2.matchs', ['matchesJson' => $matchesJson]);
})->name('matches');

Route::get('/my-bets', function () {
    return view('sportsbet2.mes-paris');
})->name('my-bets');

Route::get('/dashboard', function () {
    return view('sportsbet2.dashboard');
})->name('dashboard');
