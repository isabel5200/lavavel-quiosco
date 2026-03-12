<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\StatisticsController;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::post('/logout', [AuthController::class, 'logout']);

    Route::apiResource('/orders', OrderController::class);
    Route::apiResource('/products', ProductController::class);
    Route::apiResource('/users', UserController::class);

    Route::put('/edit-user', [UserController::class, 'editUser']);
    Route::get('/get-user-info', [UserController::class, 'getUserInfo']);

    Route::get('/best-selling-products', [StatisticsController::class, 'bestSellingProducts']);
    Route::get('/earnings-by-category', [StatisticsController::class, 'earningsByCategory']);
});

Route::apiResource('/categories', CategoryController::class);

// Authentication
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
