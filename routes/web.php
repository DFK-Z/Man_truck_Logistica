<?php

use App\Http\Controllers\ReviewController;
use App\Http\Controllers\TruckController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminReviewController;
use Illuminate\Support\Facades\Route;

// ==================== ПУБЛИЧНЫЕ МАРШРУТЫ ====================
Route::get('/', [TruckController::class, 'index'])->name('home');
Route::get('/truck/{id}', [TruckController::class, 'show'])->name('truck.detail');

// Маршруты для отзывов
Route::get('/reviews', [ReviewController::class, 'index'])->name('reviews.index');
Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');

// Простые маршруты для входа
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ==================== FILAMENT (если нужно) ====================
Route::get('/admin/login', function () {
    return view('login');
})->name('filament.admin.auth.login');

Route::get('/admin', function () {
    return redirect('/admin/login');
})->name('filament.admin.pages.dashboard');

// ==================== АДМИНКА (ТОЛЬКО ДЛЯ АДМИНИСТРАТОРОВ) ====================
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    // Управление грузовиками
    Route::get('/', [AdminController::class, 'index'])->name('admin.index');
    Route::get('/create', [AdminController::class, 'create'])->name('admin.create');
    Route::post('/store', [AdminController::class, 'store'])->name('admin.store');
    Route::get('/{truck}/edit', [AdminController::class, 'edit'])->name('admin.edit');
    Route::put('/{truck}', [AdminController::class, 'update'])->name('admin.update');
    Route::delete('/{truck}', [AdminController::class, 'destroy'])->name('admin.destroy');

    // Управление отзывами
    Route::get('/reviews', [AdminReviewController::class, 'index'])->name('admin.reviews');
    Route::post('/reviews/{review}/approve', [AdminReviewController::class, 'approve'])->name('admin.reviews.approve');
    Route::post('/reviews/{review}/toggle', [AdminReviewController::class, 'toggleApproval'])->name('admin.reviews.toggle');
    Route::delete('/reviews/{review}', [AdminReviewController::class, 'destroy'])->name('admin.reviews.destroy');
});
