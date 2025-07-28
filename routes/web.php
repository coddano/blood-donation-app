<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DemandeController;
use App\Http\Controllers\DonneurController;
use App\Http\Controllers\ProfileController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function (){

    Route::get('/devenir-donneur',[DonneurController::class, 'create'])->name('donneurs.create');

Route::post('/devenir-donneur', [DonneurController::class, 'store'])->name('donneurs.store');

Route::get('/faire-une-demande', [DemandeController::class, 'create'])->name('demandes.create');

Route::post('/faire-une-demande', [DemandeController::class, 'store'])->name('demandes.store');

Route::get('/demande/{demande}/resultats', [DemandeController::class, 'resultats'])->name('demandes.resultats');

});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
