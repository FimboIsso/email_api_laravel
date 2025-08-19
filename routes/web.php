<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('mail-api-docs');
})->name('home');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Dashboard routes
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/dashboard/generate-token', [DashboardController::class, 'generateToken'])->name('dashboard.generate-token');
    Route::post('/dashboard/update-mail-config', [DashboardController::class, 'updateMailConfig'])->name('dashboard.update-mail-config');
    Route::post('/dashboard/test-mail', [DashboardController::class, 'testMailConfig'])->name('dashboard.test-mail');
});

require __DIR__ . '/auth.php';
