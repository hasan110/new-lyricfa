<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\V1\SettingController;

Route::prefix('app')->group(function () {
    Route::get('/get-settings', [SettingController::class , 'getSettings']);
});
