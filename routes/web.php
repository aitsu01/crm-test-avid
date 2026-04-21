<?php

use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::avidPrivate(function () {
    Route::middleware(['auth', 'verified'])->group(function () {
        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    });
});
