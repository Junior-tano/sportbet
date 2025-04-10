<?php

use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/', function () {
    return view('sportsbet2.index');
})->name('home');

Route::get('/matches', function () {
    return view('sportsbet2.matchs');
})->name('matches');

Route::get('/my-bets', function () {
    return view('sportsbet2.mes-paris');
})->name('my-bets');

Route::get('/dashboard', function () {
    return view('sportsbet2.dashboard');
})->name('dashboard');
