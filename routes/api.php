<?php

use App\Http\Controllers\Api\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


//Products Route

Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/{product}', [ProductController::class, 'show']);
Route::get('/products/{category}/category', [ProductController::class, 'filterProductsByCategory']);
Route::get('/products/{brand}/brand', [ProductController::class, 'filterProductsByBrand']);
Route::get('/products/{color}/color', [ProductController::class, 'filterProductsByColor']);
Route::get('/products/{size}/size', [ProductController::class, 'filterProductsBySize']);
Route::get('/products/{searchterm}/find', [ProductController::class, 'filterProductsByTerm']);
Route::get('/products/{product}/', [ProductController::class, 'show']);
