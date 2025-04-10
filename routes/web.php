<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\GameMatchController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Page d'accueil
Route::get('/', function () {
    // Récupérer les matchs depuis le contrôleur pour la page d'accueil
    $matchController = app(GameMatchController::class);
    $matches = $matchController->index();
    
    // Convertir les données en JSON correctement formaté
    $matchesJson = json_encode($matches);
    
    return view('sportsbet2.index', ['matchesJson' => $matchesJson]);
})->name('home');

// Page des matchs
Route::get('/matches', function () {
    // Récupérer les matchs depuis le contrôleur
    $matchController = app(GameMatchController::class);
    $matches = $matchController->index();
    
    // Convertir les données en JSON correctement formaté
    $matchesJson = json_encode($matches);
    
    return view('sportsbet2.matchs', ['matchesJson' => $matchesJson]);
})->name('matches');

// Page de match individuel
Route::get('/matches/{id}', function ($id) {
    return view('sportsbet2.match-details', ['matchId' => $id]);
})->name('match.details');

// Routes authentifiées
Route::middleware('auth')->group(function () {
    // Dashboard
    Route::get('/dashboard', function () {
        return view('sportsbet2.dashboard');
    })->name('dashboard');
    
    // Profil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Gestion des paris
    Route::get('/my-bets', function () {
        return view('sportsbet2.mes-paris');
    })->name('my.bets');
});

// Routes d'authentification
require __DIR__.'/auth.php';
