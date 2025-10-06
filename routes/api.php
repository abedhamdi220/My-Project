<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Client\AuthController;
use App\Http\Controllers\Client\OrderController;
use App\Http\Controllers\Client\FavoriteController;
use App\Http\Controllers\Global\CategoryController;
use App\Http\Controllers\Provider\AuthController as ProviderAuthController;
use App\Http\Controllers\Client\ServiceController as ClientServiceController;
use App\Http\Controllers\Provider\OrderController as ProviderOrderController;
use App\Http\Controllers\Provider\ServiceController as ProviderServiceController;


// Client
Route::prefix("client")->group(function () {
    Route::post("register", [AuthController::class, "register"]);
    Route::post("login", [AuthController::class, "login"]);

    Route::middleware("auth:api")->group(function () {
        Route::get("profile", [AuthController::class, "profile"]);
        // Categories for Clients
        Route::prefix("categories")->group(function () {
            Route::get("/", [CategoryController::class, "apiIndex"]);
        });

        // Services for Clients
        Route::prefix("services")->group(function () {
            Route::get("/", [ClientServiceController::class, "index"]);
            Route::get("/{id}", [ClientServiceController::class, "show"]);
            Route::get("/category/{categoryId}", [ClientServiceController::class, "byCategory"]);
            Route::get("/provider/{providerId}", [ClientServiceController::class, "byProvider"]);
        });
        Route::prefix("orders")->group(function () {
            Route::post("/", [OrderController::class,"store"]);
            Route::get("/", [OrderController::class,"index"]);

        });
          Route::prefix("favorites")->group(function () {
            Route::get("/", [FavoriteController::class,"index"]);
             Route::post("/", [FavoriteController::class,"store"]);
              Route::delete("/{service_id}", [FavoriteController::class,"destroy"]);
    });
});
});

// Provider
Route::prefix("provider")->group(function () {
    Route::post("register", [ProviderAuthController::class, "register"]);
    Route::post("login", [ProviderAuthController::class, "login"]);
    Route::middleware("auth:api")->group(function () {
        Route::get("profile", [ProviderAuthController::class, "profile"]);

        // Categories for Providers
        Route::prefix("categories")->group(function () {
            Route::get("/", [CategoryController::class, "apiIndex"]);
        });
    
            Route::apiResource('services', ProviderServiceController::class);
        });
        Route::prefix('orders')->group(function () {
            Route::get('/', [OrderController::class,'index']);
            Route::put('/change-status/{order}', [OrderController::class,'changeStatus']);
        });

        // Services for Providers
        // Route::prefix("services")->group(function () {
        //      Route::post("/", [ProviderServiceController::class, "store"]);
        //     Route::get("/", [ProvidrviceControlerSeler::class, "index"]);
        //     Route::get("/{id}", [ProviderServiceController::class, "show"]);
        //     Route::put("/{id}", [ProviderServiceController::class, "update"]);
        //     Route::delete("/{id}", [ProviderServiceController::class, "destroy"]);
        // });
    });


  
