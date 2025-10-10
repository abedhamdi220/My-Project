<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Client\AuthController;
use App\Http\Controllers\Client\OrderController;
use App\Http\Controllers\Client\FavoriteController;
use App\Http\Controllers\Client\NotificationController;
use App\Http\Controllers\Global\CategoryController;
use App\Http\Controllers\Provider\AuthController as ProviderAuthController;
use App\Http\Controllers\Client\ServiceController as ClientServiceController;
use App\Http\Controllers\Provider\NotificationController as ProviderNotificationController;
use App\Http\Controllers\Provider\OrderController as ProviderOrderController;
use App\Http\Controllers\Provider\ServiceController as ProviderServiceController;


// CLIENT ROUTES

Route::prefix("client")->group(function () {

    // Auth routes
    Route::post("register", [AuthController::class, "register"]);
    Route::post("login", [AuthController::class, "login"]);

    Route::middleware("auth:api")->group(function () {

        // Profile
        Route::get("profile", [AuthController::class, "profile"]);

        // Categories
        Route::prefix("categories")->group(function () {
            Route::get("/", [CategoryController::class, "apiIndex"]);
        });

        // Services for Clients
        Route::prefix("services")->group(function () {
            Route::get("/", [ClientServiceController::class, "index"]);
            Route::get("/{id}", [ClientServiceController::class, "show"]);
            Route::get("category/{categoryId}", [ClientServiceController::class, "byCategory"]);
            Route::get("provider/{providerId}", [ClientServiceController::class, "byProvider"]);
        });

        // Orders for Clients
        Route::prefix("orders")->group(function () {
            Route::post("/", [OrderController::class, "store"]);
            Route::get("/", [OrderController::class, "index"]);
            Route::post("rate/{order}", [OrderController::class, "rate"])->name("client.orders.rate");
        });

        // Favorites for Clients
        Route::prefix("favorites")->group(function () {
            Route::get("/", [FavoriteController::class, "index"]);
            Route::post("/", [FavoriteController::class, "store"]);
            Route::delete("/{service_id}", [FavoriteController::class, "destroy"]);
        });
          Route::prefix("Notification")->group(function () {
         Route::get("", [NotificationController::class, "getNotifications"]);
          Route::post("{notification}/read", [NotificationController::class, "markAsRead"]);
         });
    });
});


// PROVIDER ROUTES

Route::prefix("provider")->group(function () {

    // Auth routes
    Route::post("register", [ProviderAuthController::class, "register"]);
    Route::post("login", [ProviderAuthController::class, "login"]);

    Route::middleware("auth:api")->group(function () {

        // Profile
        Route::get("profile", [ProviderAuthController::class, "profile"]);

        // Categories
        Route::prefix("categories")->group(function () {
            Route::get("/", [CategoryController::class, "apiIndex"]);
        });

        // Services for Providers
        Route::apiResource("services", ProviderServiceController::class);

        // Orders for Providers
        Route::prefix("orders")->group(function () {
            Route::get("/", [ProviderOrderController::class, "index"]);
            Route::put("change-status/{order}", [ProviderOrderController::class, "changeStatus"]);

        });
         Route::prefix("Notification")->group(function () {
         Route::get("", [ProviderNotificationController::class, "getNotifications"]);
          Route::post("{notification}/read", [ProviderNotificationController::class, "markAsRead"]);
         });
    });
});

