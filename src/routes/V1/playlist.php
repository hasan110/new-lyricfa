<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\V1\PlaylistController;

Route::prefix('playlist')->middleware(['auth:sanctum'])->group(function () {
    Route::get( '/list',         [PlaylistController::class , 'list']);
    Route::post('/add',          [PlaylistController::class , 'add']);
    Route::post('/edit',         [PlaylistController::class , 'edit']);
    Route::post('/remove',       [PlaylistController::class , 'remove']);
    Route::get( '/music/list',   [PlaylistController::class , 'getMusicList']);
    Route::post('/music/add',    [PlaylistController::class , 'addMusic']);
    Route::post('/music/remove', [PlaylistController::class , 'removeMusic']);
});
