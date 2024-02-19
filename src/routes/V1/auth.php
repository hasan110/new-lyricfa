<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\V1\AuthController;

Route::prefix('auth')->group(function () {
    Route::post('/authenticate',  [AuthController::class , 'authenticate']);
    Route::post('/otp',           [AuthController::class , 'otp']);
});
