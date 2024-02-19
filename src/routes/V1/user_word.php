<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\V1\UserWordController;

Route::prefix('user-word')->middleware(['auth:sanctum'])->group(function () {
    Route::get(  '/list',   [UserWordController::class , 'list']);
    Route::post( '/add',    [UserWordController::class , 'add']);
    Route::post( '/remove', [UserWordController::class , 'remove']);
    Route::get(  '/review', [UserWordController::class , 'review']);
    Route::get(  '/box',    [UserWordController::class , 'box']);
    Route::post( '/learn',  [UserWordController::class , 'learn']);
});
