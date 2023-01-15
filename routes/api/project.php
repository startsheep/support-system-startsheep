<?php

use App\Http\Controllers\ProjectController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->prefix('project')->group(function () {
    Route::get('/', [ProjectController::class, 'index'])
        ->name('api.project.index')
        ->middleware('can:project.index');

    Route::post('/', [ProjectController::class, 'store'])
        ->name('api.project.store')
        ->middleware('can:project.create');

    Route::get('/{id}', [ProjectController::class, 'show'])
        ->name('api.project.show')
        ->middleware('can:project.show');

    Route::put('/{id}', [ProjectController::class, 'update'])
        ->name('api.project.update')
        ->middleware('can:project.edit');

    Route::delete('/{id}', [ProjectController::class, 'destroy'])
        ->name('api.project.destroy')
        ->middleware('can:project.delete');
});
