<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::avidPrivate(function () {
    Route::middleware(['auth', 'verified'])->group(function () {
        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

        Route::delete('users/bulk-destroy', [UserController::class, 'bulkDestroy'])
            ->name('users.bulk.destroy');
        Route::resource('users', UserController::class);

        Route::delete('projects/bulk-destroy', [ProjectController::class, 'bulkDestroy'])
            ->name('projects.bulk.destroy');
        Route::resource('projects', ProjectController::class);
    });
});