<?php

use App\Http\Controllers\CommentController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->prefix('comment')->group(function () {
    Route::get('/', [CommentController::class, 'index'])->name('api.comment.index');
    Route::post('/', [CommentController::class, 'store'])->name('api.comment.store');
    Route::get('/{id}', [CommentController::class, 'show'])->name('api.comment.show');
    Route::put('/{id}', [CommentController::class, 'update'])->name('api.comment.update');
    Route::delete('/{id}', [CommentController::class, 'destroy'])->name('api.comment.destroy');
});
