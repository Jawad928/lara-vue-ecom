<?php

use App\Http\Controllers\admin\AdminController;
use App\Http\Controllers\admin\BrandController;
use App\Http\Controllers\admin\CategoryController;
use App\Http\Controllers\admin\ColorController;
use App\Http\Controllers\admin\CouponController;
use App\Http\Controllers\admin\ProductController;
use App\Http\Controllers\admin\SizeController;
use App\Models\Brand;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/', [AdminController::class, 'login'])->name('admin.login');
Route::post('auth', [AdminController::class, 'auth'])->name('admin.auth');

Route::prefix('admin')->middleware('admin')->group(function () {
    Route::get('dashboard', [AdminController::class, 'index'])->name('admin.index');
    Route::post('logout', [AdminController::class, 'logout'])->name('admin.logout');


    //categories route
    Route::resource("categories", CategoryController::class, [

        'names' => [
            'index' => "admin.categories.index",
            'create' => "admin.categories.create",
            'store' => "admin.categories.store",
            'edit' => "admin.categories.edit",
            'update' => "admin.categories.update",
            'destroy' => "admin.categories.destroy",

        ]
    ])->parameters(['categories' => 'category:slug']);

    //Brands route
    Route::resource("brands", BrandController::class, [

        'names' => [
            'index' => "admin.brands.index",
            'create' => "admin.brands.create",
            'store' => "admin.brands.store",
            'edit' => "admin.brands.edit",
            'update' => "admin.brands.update",
            'destroy' => "admin.brands.destroy",

        ]
    ])->parameters(['brands' => 'brand:slug']);

    //Colors route

    Route::resource("colors", ColorController::class, [

        'names' => [
            'index' => "admin.colors.index",
            'create' => "admin.colors.create",
            'store' => "admin.colors.store",
            'edit' => "admin.colors.edit",
            'update' => "admin.colors.update",
            'destroy' => "admin.colors.destroy",

        ]
    ]);
    //Sizes route

    Route::resource("sizes", SizeController::class, [

        'names' => [
            'index' => "admin.sizes.index",
            'create' => "admin.sizes.create",
            'store' => "admin.sizes.store",
            'edit' => "admin.sizes.edit",
            'update' => "admin.sizes.update",
            'destroy' => "admin.sizes.destroy",

        ]
    ]);

    //Products route
    Route::resource("products", ProductController::class, [

        'names' => [
            'index' => "admin.products.index",
            'create' => "admin.products.create",
            'store' => "admin.products.store",
            'edit' => "admin.products.edit",
            'update' => "admin.products.update",
            'destroy' => "admin.products.destroy",

        ]
    ]);
    //Coupon route
    Route::resource("coupons", CouponController::class, [

        'names' => [
            'index' => "admin.coupons.index",
            'create' => "admin.coupons.create",
            'store' => "admin.coupons.store",
            'edit' => "admin.coupons.edit",
            'update' => "admin.coupons.update",
            'destroy' => "admin.coupons.destroy",

        ]
    ]);
});