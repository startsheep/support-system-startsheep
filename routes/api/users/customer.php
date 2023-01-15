<?php

use App\Http\Controllers\Users\CustomerController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->prefix('user/customer')->group(function () {
    Route::get('/', [CustomerController::class, 'index'])
        ->name('api.user.customer.index')
        ->middleware('permission:customer.index');

    Route::post('/', [CustomerController::class, 'store'])
        ->name('api.user.customer.store')
        ->middleware('permission:customer.create');

    Route::get('/{id}', [CustomerController::class, 'show'])
        ->name('api.user.customer.show')
        ->middleware('permission:customer.show');

    Route::put('/{id}', [CustomerController::class, 'update'])
        ->name('api.user.customer.update')
        ->middleware('permission:customer.edit');

    Route::delete('/{id}', [CustomerController::class, 'destroy'])
        ->name('api.user.customer.destroy')
        ->middleware('permission:customer.delete');
});
