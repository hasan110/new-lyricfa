<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\V1\MusicController;

Route::prefix('music')->middleware(['auth:sanctum'])->group(function () {
    Route::get( '/list',      [MusicController::class , 'list']);
    Route::get( '/info/{id}', [MusicController::class , 'info']);
    Route::post( '/add-view', [MusicController::class , 'addView']);
});
