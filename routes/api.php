<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\ProductController;

Route::post('/user/register', [UserController::class, 'store']);
Route::post('/user/auth', [UserController::class, 'auth']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user/profile', [UserController::class, 'profile']);
    Route::post('/user/logout', [UserController::class, 'logout']);

    Route::put('user/update/profile', [UserController::class, 'UpdateUserProfile']);

    //Orders Route
    Route::post('store/order', [OrderController::class, 'storeUserOrders']);
});

Route::get('products', [ProductController::class, 'index']);
Route::get('products/{category}/category', [ProductController::class, 'filterProductByCategory']);
Route::get('products/{searchTerm}/find', [ProductController::class, 'filterProductByTerm']);
Route::get('/search/products', [ProductController::class, 'quickSearch']);
Route::get('/products/recommended', [ProductController::class, 'recommended']);
Route::get('/products/{product}/show', [ProductController::class, 'show']);

Route::get('/locations/provinces', [App\Http\Controllers\Api\LocationController::class, 'getProvinces']);
