<?php

use App\Http\Controllers\LandingController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CombatController;
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

Route::middleware(['auth', 'verified', \App\Http\Middleware\EnsureHasActiveCharacter::class])->group(function () {
    Route::get('/city', [\App\Http\Controllers\GameController::class, 'city'])->name('city');
    Route::get('/city/armorer', [\App\Http\Controllers\GameController::class, 'armorer'])->name('city.armorer');
    Route::get('/city/weaponsmith', [\App\Http\Controllers\GameController::class, 'weaponsmith'])->name('city.weaponsmith');
    Route::get('/city/blacksmith', [\App\Http\Controllers\GameController::class, 'blacksmith'])->name('city.blacksmith');
    Route::get('/city/merchant', [\App\Http\Controllers\GameController::class, 'merchant'])->name('city.merchant');
    Route::get('/city/adventure', [\App\Http\Controllers\GameController::class, 'adventure'])->name('city.adventure');
    Route::get('/city/tavern', [\App\Http\Controllers\GameController::class, 'tavern'])->name('city.tavern');
    Route::post('/city/tavern/heal', [\App\Http\Controllers\GameController::class, 'heal'])->name('city.tavern.heal');
    
    // Character Stats Routes
    Route::get('/character/stats', [\App\Http\Controllers\CharacterController::class, 'stats'])->name('character.stats');
    Route::post('/character/allocate-stat', [\App\Http\Controllers\CharacterController::class, 'allocateStat'])->name('character.allocateStat');
    
    // Combat Routes
    Route::get('/combat/start/{location}', [CombatController::class, 'start'])->name('game.combat.start');
    Route::get('/combat', [CombatController::class, 'index'])->name('game.combat');
    Route::post('/combat/attack', [CombatController::class, 'attack'])->name('game.combat.attack');
});


require __DIR__.'/auth.php';
