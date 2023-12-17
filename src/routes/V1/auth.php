<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\V1\AuthController;

Route::prefix('auth')->group(function () {
    Route::post('/send-otp-code',  [AuthController::class , 'sendOtpCode']);
    Route::post('/check-otp-code', [AuthController::class , 'checkOtpCode']);
});
