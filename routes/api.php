<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::controller(AuthController::class)
    ->prefix('auth')
    ->as('auth.')
    ->group(function () {
        Route::post('/register', 'register')->name('register');
        Route::post('/login', 'login')->name('login');
    });
