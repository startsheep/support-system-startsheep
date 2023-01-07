<?php

use App\Http\Controllers\Users\AdminController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->prefix('user/admin')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('api.user.admin.index');
    Route::post('/', [AdminController::class, 'store'])->name('api.user.admin.store');
    Route::get('/{id}', [AdminController::class, 'show'])->name('api.user.admin.show');
    Route::put('/{id}', [AdminController::class, 'update'])->name('api.user.admin.update');
    Route::delete('/{id}', [AdminController::class, 'destroy'])->name('api.user.admin.destroy');
});
