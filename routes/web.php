<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

Route::avidPrivate(function () {
    Route::middleware(['auth', 'verified'])->group(function () {
        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

        Route::delete('users/bulk-destroy', [UserController::class, 'bulkDestroy'])
            ->name('users.bulk.destroy');
        Route::resource('users', UserController::class);

        Route::delete('projects/bulk-destroy', [ProjectController::class, 'bulkDestroy'])
            ->name('projects.bulk.destroy');
        Route::resource('projects', ProjectController::class);

        Route::delete('tasks/bulk-destroy', [TaskController::class, 'bulkDestroy'])
            ->name('tasks.bulk.destroy');
        Route::resource('tasks', TaskController::class);

        Route::get('logout-link', function (Request $request) {
    Auth::logout();

    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect()->route('login');
})->name('logout.link');



    });
});