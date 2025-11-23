<?php

use App\Http\Controllers\LandingController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', [LandingController::class, 'index'])->name('home');

// Character routes (require authentication)
Route::middleware('auth')->group(function () {
    Route::get('/characters/create', [\App\Http\Controllers\CharacterController::class, 'create'])->name('characters.create');
    Route::post('/characters', [\App\Http\Controllers\CharacterController::class, 'store'])->name('characters.store');
    Route::post('/characters/{character}/activate', [\App\Http\Controllers\CharacterController::class, 'activate'])->name('characters.activate');
    Route::delete('/characters/{character}', [\App\Http\Controllers\CharacterController::class, 'destroy'])->name('characters.destroy');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
