<?php

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\TagApiController;
use App\Http\Controllers\Api\PostApiController;
use App\Http\Controllers\Api\CommentApiController;
use App\Http\Controllers\Api\CategoryApiController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('login', [AuthenticatedSessionController::class, 'storeApi']);

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('posts', PostApiController::class);
    Route::apiResource('comments', CommentApiController::class);
    Route::apiResource('categories', CategoryApiController::class);
    Route::apiResource('tags', TagApiController::class);
    
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy']);
});