<?php

use App\Http\Controllers\TicketStatusController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->prefix('ticket-status')->group(function () {
    Route::get('/', [TicketStatusController::class, 'index'])
        ->name('api.ticket.status.index');
});
