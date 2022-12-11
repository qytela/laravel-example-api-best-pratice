<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\ArticleController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('auth')->group(function () {
    Route::post('register', RegisterController::class);
});

Route::prefix('users')->group(function () {
    Route::middleware('auth:api')->group(function () {
        Route::middleware('role:superadmin')->group(function () {
            Route::get('', [UserController::class, 'index']);
            Route::get('{user}/show', [UserController::class, 'show']);
        });
        Route::get('profile', [UserController::class, 'profile']);
    });
});

Route::prefix('articles')->group(function () {
    Route::middleware('auth:api')->group(function () {
        Route::get('', [ArticleController::class, 'index']);
        Route::middleware('role:superadmin|admin')->group(function () {
            Route::post('', [ArticleController::class, 'store']);
        });
    });
});
