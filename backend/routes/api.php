<?php

use App\Http\Controllers\Api\CouponController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\api\UserController;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



// Route::get('/test-api', function () {

//     return response()->json(['message' => 'API is working']);
// });




Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return [
            'user' => UserResource::make($request->user()),
            'access_token' => $request->bearerToken()
        ];
    });

    Route::post('user/logout', [UserController::class, 'logout']);
    Route::put(('user/profile/update'), [UserController::class, 'UpdateUserProfile']);

    //coupon routes
    Route::post('apply/coupon', [CouponController::class, 'applyCoupon']);
});

//Products Routes

Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/{product}', [ProductController::class, 'show']);
Route::get('/products/{category}/category', [ProductController::class, 'filterProductsByCategory']);
Route::get('/products/{brand}/brand', [ProductController::class, 'filterProductsByBrand']);
Route::get('/products/{color}/color', [ProductController::class, 'filterProductsByColor']);
Route::get('/products/{size}/size', [ProductController::class, 'filterProductsBySize']);
Route::get('/products/{searchterm}/find', [ProductController::class, 'filterProductsByTerm']);
Route::get('/products/{product}/show', [ProductController::class, 'show']);


//user Routes
Route::post('user/register', [UserController::class, 'store']);
Route::post('user/login', [UserController::class, 'auth']);