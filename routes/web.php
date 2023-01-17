<?php

use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/{any}', [PageController::class, 'index'])->where('any', '^(?!admin|auth|email).*$');
Route::get('/admin/{any}', [PageController::class, 'admin']);
Route::get('/auth/{any}', [PageController::class, 'auth']);
Route::get('/email', function () {
    return view('emails.assign-to');
});
