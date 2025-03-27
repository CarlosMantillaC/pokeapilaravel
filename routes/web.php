<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PokemonController;

Route::get('/', [PokemonController::class, 'index'])->name('index');
Route::get('/pokemon/{id}', [PokemonController::class, 'show'])->name('show');
Route::get('/create', [PokemonController::class, 'create'])->name('create');
Route::post('/pokemon', [PokemonController::class, 'store'])->name('store');
