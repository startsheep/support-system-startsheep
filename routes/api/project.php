<?php

use App\Http\Controllers\ProjectController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->prefix('project')->group(function () {
    Route::get('/', [ProjectController::class, 'index'])->name('api.project.index');
    Route::post('/', [ProjectController::class, 'store'])->name('api.project.store');
    Route::get('/{id}', [ProjectController::class, 'show'])->name('api.project.show');
    Route::put('/{id}', [ProjectController::class, 'update'])->name('api.project.update');
    Route::delete('/{id}', [ProjectController::class, 'destroy'])->name('api.project.destroy');
});
