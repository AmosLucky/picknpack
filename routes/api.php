<?php

use App\Http\Controllers\Api\AuthController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Authentication
    |--------------------------------------------------------------------------
    */

    Route::post('/auth/login', [
        AuthController::class,
        'login',
    ])->name('api.v1.auth.login');


    /*
    |--------------------------------------------------------------------------
    | Protected API
    |--------------------------------------------------------------------------
    */

    Route::middleware('auth:sanctum')->group(function () {

        Route::get('/auth/me', [
            AuthController::class,
            'me',
        ])->name('api.v1.auth.me');

        Route::post('/auth/logout', [
            AuthController::class,
            'logout',
        ])->name('api.v1.auth.logout');

    });

});