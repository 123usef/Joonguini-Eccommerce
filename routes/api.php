<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Cart API routes - accessible for both authenticated and guest users
Route::prefix('cart')->group(function () {
    Route::post('/add', [CartController::class, 'add'])->name('api.cart.add');
    Route::post('/remove', [CartController::class, 'remove'])->name('api.cart.remove');
    Route::post('/update', [CartController::class, 'update'])->name('api.cart.update');
    Route::get('/get', [CartController::class, 'get'])->name('api.cart.get');
    Route::get('/count', [CartController::class, 'count'])->name('api.cart.count');
    Route::post('/clear', [CartController::class, 'clear'])->name('api.cart.clear');
});
