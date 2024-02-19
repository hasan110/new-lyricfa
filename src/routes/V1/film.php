<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\V1\FilmController;

Route::prefix('film')->middleware(['auth:sanctum'])->group(function () {
    Route::get( '/list',              [FilmController::class , 'list']);
    Route::get( '/get-chapters/{id}', [FilmController::class , 'getChapters']);
});
