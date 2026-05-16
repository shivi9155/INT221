<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\GrievanceController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('dashboard');
    }

    return view('landing');
})->name('landing');

Route::middleware('guest')->group(function () {
    Route::get('/login', fn () => redirect()->route('user.login'))->name('login');
    Route::post('/login', [AuthController::class, 'userLogin']);
    Route::get('/user/login', [AuthController::class, 'showUserLogin'])->name('user.login');
    Route::post('/user/login', [AuthController::class, 'userLogin'])->name('user.login.store');
    Route::get('/admin/login', [AuthController::class, 'showAdminLogin'])->name('admin.login');
    Route::post('/admin/login', [AuthController::class, 'adminLogin'])->name('admin.login.store');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/dashboard', DashboardController::class)->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/read-all', [NotificationController::class, 'markAllRead'])->name('notifications.read-all');

    Route::resource('grievances', GrievanceController::class)->only(['index', 'create', 'store', 'show', 'update']);
    Route::post('/grievances/{grievance}/comments', [GrievanceController::class, 'addComment'])->name('grievances.comments.store');
    Route::post('/grievances/{grievance}/feedback', [FeedbackController::class, 'store'])->name('feedback.store');

    Route::middleware('admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        Route::get('/analytics', [AdminController::class, 'analytics'])->name('analytics');
        Route::get('/export', [AdminController::class, 'export'])->name('export');
        Route::get('/users', [AdminController::class, 'users'])->name('users');
        Route::put('/users/{user}/role', [AdminController::class, 'updateUserRole'])->name('users.update-role');
        Route::put('/users/{user}/status', [AdminController::class, 'toggleUserStatus'])->name('users.status');
        Route::get('/grievances/{grievance}', [AdminController::class, 'show'])->name('grievances.show');
        Route::put('/grievances/{grievance}', [AdminController::class, 'update'])->name('grievances.update');
    });
});
