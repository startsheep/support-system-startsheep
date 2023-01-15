<?php

use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->prefix('dashboard')->group(function () {
    // Route::prefix('dashboard')->group(function () {
    Route::get('/admin', [DashboardController::class, 'admin'])
        ->name('api.dashboard.admin');

    Route::get('/staff', [DashboardController::class, 'staff'])
        ->name('api.dashboard.staff');
});
