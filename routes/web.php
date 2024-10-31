<?php

use App\Http\Controllers\LivreController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\NouveautesController;
use App\Http\Controllers\MessageController;

Route::get('/', [LivreController::class, 'index']);

// Routes pour les livres
Route::get('/livres', [LivreController::class, 'index'])->name('livres.index');
Route::get('/livres/create', [LivreController::class, 'create'])->name('livres.create');
Route::post('/livres', [LivreController::class, 'store'])->name('livres.store');
Route::get('/livres/{id}', [LivreController::class, 'show'])->name('livres.show');
Route::delete('/livres/{id}', [LivreController::class, 'destroy'])->name('livres.destroy');
Route::get('/recherche', [LivreController::class, 'search'])->name('livres.search');

// Routes pour le contact et les messages
Route::get('/contact', [ContactController::class, 'index'])->name('contact.index');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');
Route::get('/nouveautes', [NouveautesController::class, 'index'])->name('nouveautes.index');
Route::get('/messages', [MessageController::class, 'index'])->name('messages.index');