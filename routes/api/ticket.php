<?php

use App\Http\Controllers\TicketController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->prefix('ticket')->group(function () {
    Route::get('/', [TicketController::class, 'index'])->name('api.ticket.index')->middleware('can:ticket.index');
    Route::post('/', [TicketController::class, 'store'])->name('api.ticket.store')->middleware('can:ticket.create');
    Route::get('/{id}', [TicketController::class, 'show'])->name('api.ticket.show')->middleware('can:ticket.show');
    Route::put('/resolve', [TicketController::class, 'resolve'])->name('api.ticket.resolve')->middleware('can:ticket.resolve');
    Route::put('/assign', [TicketController::class, 'assignTo'])->name('api.ticket.assign.to')->middleware('can:ticket.assignTo');
    Route::put('/{id}', [TicketController::class, 'update'])->name('api.ticket.update')->middleware('can:ticket.edit');
    Route::delete('/multiple-delete', [TicketController::class, 'multipleDestroy'])->name('api.ticket.multiple.destroy')->middleware('can:ticket.delete');
    Route::delete('/{id}', [TicketController::class, 'destroy'])->name('api.ticket.destroy')->middleware('can:ticket.delete');
});
