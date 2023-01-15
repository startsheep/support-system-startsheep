<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->prefix('user')->group(function () {
    Route::get('/', UserController::class)
        ->name('api.user.index');
});
