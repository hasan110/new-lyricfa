<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\V1\CommentController;

Route::prefix('comment')->middleware(['auth:sanctum'])->group(function () {
    Route::post( '/{type}/list',   [CommentController::class , 'list']);
    Route::post( '/{type}/add',    [CommentController::class , 'add']);
    Route::post( '/{type}/edit',   [CommentController::class , 'edit']);
    Route::post( '/{type}/remove', [CommentController::class , 'remove']);
});
