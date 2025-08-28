<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

// Documentation OTP
Route::get('/otp-api-docs', function () {
    return view('otp-api-docs');
})->name('otp.docs');

// Custom Authentication Routes
Route::prefix('auth')->name('auth.')->group(function () {
    Route::get('/login', [AuthController::class, 'showAuth'])->name('login');
    Route::post('/submit-email', [AuthController::class, 'submitEmail'])->name('submit-email');
    Route::get('/verify', [AuthController::class, 'showVerify'])->name('verify');
    Route::post('/verify-code', [AuthController::class, 'verifyCode'])->name('verify-code');
    Route::post('/resend-code', [AuthController::class, 'resendCode'])->name('resend-code');

    // Profile completion routes (require auth but not completed profile)
    Route::middleware('auth')->group(function () {
        Route::get('/complete-profile', [AuthController::class, 'showCompleteProfile'])->name('complete-profile');
        Route::post('/complete-profile', [AuthController::class, 'completeProfile']);
    });

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

Route::middleware(['auth', 'profile.complete'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Dashboard routes
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/dashboard/generate-token', [DashboardController::class, 'generateToken'])->name('dashboard.generate-token');
    Route::put('/dashboard/update-mail-config', [DashboardController::class, 'updateMailConfig'])->name('dashboard.update-mail-config');
    Route::post('/dashboard/test-mail', [DashboardController::class, 'testMailConfig'])->name('dashboard.test-mail');

    // New dashboard routes
    Route::get('/dashboard/tokens', [DashboardController::class, 'tokens'])->name('dashboard.tokens');
    Route::post('/dashboard/tokens', [DashboardController::class, 'createToken'])->name('dashboard.tokens.create');

    // OTP dashboard routes
    Route::get('/dashboard/otp-authentications', [DashboardController::class, 'otpAuthentications'])->name('dashboard.otp.authentications');
    Route::delete('/dashboard/tokens/{token}', [DashboardController::class, 'deleteToken'])->name('dashboard.tokens.delete');
    Route::patch('/dashboard/tokens/{token}', [DashboardController::class, 'updateToken'])->name('dashboard.tokens.update');
    Route::patch('/dashboard/tokens/{token}/toggle', [DashboardController::class, 'toggleToken'])->name('dashboard.tokens.toggle');

    Route::get('/dashboard/mail-config', [DashboardController::class, 'mailConfig'])->name('dashboard.mail-config');
    Route::put('/dashboard/mail-config', [DashboardController::class, 'updateMailConfig'])->name('dashboard.mail-config.update');
    Route::post('/dashboard/mail-config/test', [DashboardController::class, 'testMailConfig'])->name('dashboard.mail-config.test');
    Route::get('/dashboard/api-docs', [DashboardController::class, 'apiDocs'])->name('dashboard.api-docs');
    Route::get('/dashboard/analytics', [DashboardController::class, 'analytics'])->name('dashboard.analytics');
    Route::get('/dashboard/support', [DashboardController::class, 'support'])->name('dashboard.support');
});

require __DIR__ . '/auth.php';
