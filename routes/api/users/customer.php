<?php

use App\Http\Controllers\Users\CustomerController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->prefix('user/customer')->group(function () {
    Route::get('/', [CustomerController::class, 'index'])->name('api.user.customer.index')->middleware('can:customer.index');
    Route::post('/', [CustomerController::class, 'store'])->name('api.user.customer.store')->middleware('can:customer.create');
    Route::get('/{id}', [CustomerController::class, 'show'])->name('api.user.customer.show')->middleware('can:customer.show');
    Route::put('/{id}', [CustomerController::class, 'update'])->name('api.user.customer.update')->middleware('can:customer.edit');
    Route::delete('/{id}', [CustomerController::class, 'destroy'])->name('api.user.customer.destroy')->middleware('can:customer.delete');
});
