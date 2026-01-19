<?php

use App\Models\Subdistrict;
use Inertia\Inertia;
use Laravel\Fortify\Features;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\LocationController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\UserController;
use App\Models\District;

Route::get('/', [AdminController::class, 'login'])->name('admin.login');
Route::post('admin/auth', [AdminController::class, "auth"])->name("admin.auth");
Route::get('/locations/districts/{provinceId}', [LocationController::class, 'getDistricts']);

Route::get('/locations/subdistricts/{districtId}', [LocationController::class, 'getSubdistricts']);

Route::get('/_check', function () {
    return [
        'scheme' => request()->getScheme(),
        'secure' => request()->isSecure(),
        'session' => session()->getId(),
        'csrf' => csrf_token(),
    ];
});


Route::prefix("admin")->middleware("admin")->group(function () {
    Route::get('dashboard', [AdminController::class, "index"])->name("admin.index");
    Route::get('analytics/map', [App\Http\Controllers\Admin\AnalyticsController::class, "map"])->name("admin.analytics.map");
    Route::post('logout', [AdminController::class, "logout"])->name("admin.logout");


    //Categories Route
    Route::resource("categories", CategoryController::class, [
        'names' => [
            'index' => 'admin.categories.index',
            'create' => 'admin.categories.create',
            'store' => 'admin.categories.store',
            'edit' => 'admin.categories.edit',
            'update' => 'admin.categories.update',
            'destroy' => 'admin.categories.destroy',

        ]
    ]);

    //Brands Route
    Route::resource("brands", BrandController::class, [
        'names' => [
            'index' => 'admin.brands.index',
            'create' => 'admin.brands.create',
            'store' => 'admin.brands.store',
            'edit' => 'admin.brands.edit',
            'update' => 'admin.brands.update',
            'destroy' => 'admin.brands.destroy',

        ]
    ]);

    //Products Route
    Route::resource("products", ProductController::class, [
        'names' => [
            'index' => 'admin.products.index',
            'create' => 'admin.products.create',
            'store' => 'admin.products.store',
            'edit' => 'admin.products.edit',
            'update' => 'admin.products.update',
            'destroy' => 'admin.products.destroy',

        ]
    ]);

    //Locations Route
    Route::resource("locations", LocationController::class, [
        'names' => [
            'index' => 'admin.locations.index',
            'create' => 'admin.locations.create',
            'store' => 'admin.locations.store',
            'edit' => 'admin.locations.edit',
            'update' => 'admin.locations.update',
            'destroy' => 'admin.locations.destroy',

        ]
    ]);


    //Orders Route
    Route::resource("orders", OrderController::class, [
        'names' => [
            'index' => 'admin.orders.index',
            'update' => 'admin.orders.update',
        ]
    ])->only(['index', 'update']);

    //Users Route
    Route::resource("users", UserController::class, [
        'names' => [
            'index' => 'admin.users.index',
            'destroy' => 'admin.users.destroy',
        ]
    ])->only(['index', 'destroy']);
});

require __DIR__ . '/settings.php';
