<?php

use App\Http\Controllers\Auth\AuthenticatedController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->group(function () {
    Route::post('login', LoginController::class)
        ->name('api.auth.login');

    Route::middleware(['auth:sanctum'])->group(function () {
        Route::post('check', AuthenticatedController::class)
            ->name('api.auth.check');

        Route::post('logout', LogoutController::class)
            ->name('api.auth.logout');
    });
});
