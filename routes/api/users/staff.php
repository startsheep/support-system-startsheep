<?php

use App\Http\Controllers\Users\StaffController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->prefix('user/staff')->group(function () {
    Route::get('/', [StaffController::class, 'index'])
        ->name('api.user.staff.index')
        ->middleware('can:staff.index');

    Route::post('/', [StaffController::class, 'store'])
        ->name('api.user.staff.store')
        ->middleware('can:staff.create');

    Route::get('/{id}', [StaffController::class, 'show'])
        ->name('api.user.staff.show')
        ->middleware('can:staff.show');

    Route::put('/{id}', [StaffController::class, 'update'])
        ->name('api.user.staff.update')
        ->middleware('can:staff.edit');

    Route::delete('/{id}', [StaffController::class, 'destroy'])
        ->name('api.user.staff.destroy')
        ->middleware('can:staff.delete');
});
