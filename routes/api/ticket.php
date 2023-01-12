<?php

use App\Http\Controllers\TicketController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->prefix('ticket')->group(function () {
    Route::get('/', [TicketController::class, 'index'])
        ->name('api.ticket.index')
        ->middleware('permission:ticket.index|ticket.show');

    Route::post('/', [TicketController::class, 'store'])
        ->name('api.ticket.store')
        ->middleware('permission:ticket.create');

    Route::get('/{id}', [TicketController::class, 'show'])
        ->name('api.ticket.show')
        ->middleware('permission:ticket.show');

    Route::put('/resolve', [TicketController::class, 'resolve'])
        ->name('api.ticket.resolve')
        ->middleware('permission:ticket.resolve');

    Route::put('/assign', [TicketController::class, 'assignTo'])
        ->name('api.ticket.assign.to')
        ->middleware('permission:ticket.assignTo');

    Route::put('/{id}', [TicketController::class, 'update'])
        ->name('api.ticket.update')
        ->middleware('permission:ticket.edit');

    Route::delete('/multiple-delete', [TicketController::class, 'multipleDestroy'])
        ->name('api.ticket.multiple.destroy')
        ->middleware('permission:ticket.delete');

    Route::delete('/{id}', [TicketController::class, 'destroy'])
        ->name('api.ticket.destroy')
        ->middleware('permission:ticket.delete');
});
