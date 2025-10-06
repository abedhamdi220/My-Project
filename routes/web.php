<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ServiceController;
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

    // Service Management Routes for Admin
    // Route::prefix('services')->name('services.')->group(function () {
    //     Route::get('/', [ServiceController::class, 'index'])->name('index');
    //     Route::get('/{id}', [ServiceController::class, 'show'])->name('show');
    //     Route::patch('/{id}/status', [ServiceController::class, 'updateStatus'])->name('update-status');
    // });


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

