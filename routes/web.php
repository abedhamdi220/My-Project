<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Global\NotificationController;
use Illuminate\Support\Facades\Route;

// Authentication Routes
// Admin
Route::get("login", [AuthController::class, "loginView"])->name("login");
Route::post("login", [AuthController::class, "login"])->name("login_action");
Route::post("logout", [AuthController::class, "logout"])->name("logout");

// Protected Admin Routes
Route::middleware(['auth'])->group(function () {
    Route::get("dashboard", [DashboardController::class, "index"])->name("home");

    // Category Management Routes
    Route::prefix('categories')->name('categories.')->group(function () {
        Route::get('/', [CategoryController::class, 'index'])->name('index');
        Route::get('/create', [CategoryController::class, 'create'])->name('create');
        Route::post('/', [CategoryController::class, 'store'])->name('store');
        Route::get('/{id}', [CategoryController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [CategoryController::class, 'edit'])->name('edit');
        Route::put('/{id}', [CategoryController::class, 'update'])->name('update');
        Route::delete('/{id}', [CategoryController::class, 'destroy'])->name('destroy');
    });

   Route::prefix('notifications')->name('notifications.')->group(function () {
    Route::get('/', [NotificationController::class, 'index'])->name('notifications.index');
    Route::get('/unread-count', [NotificationController::class, 'unreadCount'])->name('notifications.unreadCount');
    Route::post('/mark-all-read', [NotificationController::class, 'markAllAsRead'])->name('notifications.markAllRead'); // أضف هذا السطر
    Route::post('/{id}/mark-read', [NotificationController::class, 'markAsRead'])->name('notifications.markAsRead');
});


Route::prefix('orders')->name('orders.')->group(function () {
    Route::get('/', [OrderController::class, 'index'])->name('index');
    Route::get('/{order}', [OrderController::class, 'show'])->name('show');
});

});


// Admin services routes (kept for backwards compatibility) — NOW protected
Route::prefix('admin')->name('admin.')->middleware('auth')->group(function() {
    Route::get('services', [ServiceController::class, 'index'])->name('services.index');
    Route::get('services/{id}', [ServiceController::class, 'show'])->name('services.show');
    Route::post('services/{id}/status', [ServiceController::class, 'updateStatus'])->name('services.updateStatus');
});

