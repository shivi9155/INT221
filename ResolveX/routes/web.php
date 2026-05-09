<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\GrievanceController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/dashboard');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/dashboard', DashboardController::class)->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::resource('grievances', GrievanceController::class)->only(['index', 'create', 'store', 'show', 'update']);
    Route::post('/grievances/{grievance}/comments', [GrievanceController::class, 'addComment'])->name('grievances.comments.store');
    Route::post('/grievances/{grievance}/feedback', [FeedbackController::class, 'store'])->name('feedback.store');

    Route::middleware('admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        Route::get('/analytics', [AdminController::class, 'analytics'])->name('analytics');
        Route::get('/export', [AdminController::class, 'export'])->name('export');
        Route::get('/grievances/{grievance}', [AdminController::class, 'show'])->name('grievances.show');
        Route::put('/grievances/{grievance}', [AdminController::class, 'update'])->name('grievances.update');
    });
});
