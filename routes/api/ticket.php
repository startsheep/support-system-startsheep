<?php

use App\Http\Controllers\TicketController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->prefix('ticket')->group(function () {
    Route::get('/', [TicketController::class, 'index'])->name('api.ticket.index');
    Route::post('/', [TicketController::class, 'store'])->name('api.ticket.store');
    Route::get('/{id}', [TicketController::class, 'show'])->name('api.ticket.show');
    Route::put('/{id}', [TicketController::class, 'update'])->name('api.ticket.update');
    Route::delete('/multiple-delete', [TicketController::class, 'multipleDestroy'])->name('api.ticket.multiple.destroy');
    Route::delete('/{id}', [TicketController::class, 'destroy'])->name('api.ticket.destroy');
});
