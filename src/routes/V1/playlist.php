<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\V1\UserController;

Route::prefix('playlist')->middleware(['auth:sanctum'])->group(function () {
    Route::post('/add',         [UserController::class , 'getUser']);
    Route::post('/add-subscription', [UserController::class , 'addSubscription']);
    Route::post('/save-fcm-token',   [UserController::class , 'saveFcmToken']);
});
