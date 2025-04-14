<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OrderController;

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::controller(UserController::class)
        ->prefix('users')
        ->group(function () {
            Route::get('/profile', 'profile');
        });

    Route::controller(OrderController::class)
        ->prefix('orders')
        ->group(function () {
            Route::get('/', 'index');
            Route::post('/', 'store');
            Route::get('/{order}', 'show');
            Route::patch('/{order}/status', 'changeStatus')
                ->name('orders.change-status')
                ->middleware('allowed-order-status');
        });
});