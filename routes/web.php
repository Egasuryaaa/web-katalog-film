<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\FilmController;
use App\Http\Controllers\CommentController;

Route::get('/films', [FilmController::class, 'index'])->name('films.index');
Route::get('/films/{id}', [FilmController::class, 'show'])->name('films.show');
Route::post('/films/{id}/comments', [FilmController::class, 'storeComment'])->name('films.comments.store');
