<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});
Route::post('/auth/login',[\App\Http\Controllers\Auth\LoginController::class, 'login'])->name('login');
Route::post('/auth/register',[\App\Http\Controllers\Auth\RegisterController::class, 'store']);

Route::group(['middleware' => 'auth:api'], function ($router) {

    Route::post('/auth/logout',[\App\Http\Controllers\Auth\LogoutController::class, 'logout'])->middleware('throttle:30,1');
    Route::post('/auth/refresh',[\App\Http\Controllers\Auth\LoginController::class, 'refresh'])->middleware('throttle:30,1');

    Route::get('/products', [\App\Http\Controllers\ProductController::class, 'index'])->middleware('throttle:30,1');
    Route::get('/products/{id}', [\App\Http\Controllers\ProductController::class, 'show'])->where('id', '[0-9]+')->middleware('throttle:30,1');
    Route::post('/products', [\App\Http\Controllers\ProductController::class, 'store'])->middleware('is_admin','throttle:30,1');
    Route::put('/products/{id}', [\App\Http\Controllers\ProductController::class, 'update'])->where('id', '[0-9]+')->middleware('is_admin','throttle:30,1');
    Route::delete('/products/{id}', [\App\Http\Controllers\ProductController::class, 'delete'])->where('id', '[0-9]+')->middleware('is_admin','throttle:30,1');

    Route::get('/cart', [\App\Http\Controllers\CartController::class, 'index'])->middleware('throttle:30,1');
    Route::post('/cart/items', [\App\Http\Controllers\CartController::class, 'store'])->middleware('throttle:30,1');
    Route::put('/cart/items/{id}', [\App\Http\Controllers\CartItemController::class, 'update'])->where('id', '[0-9]+')->middleware('throttle:30,1');
    Route::delete('/cart/items/{id}', [\App\Http\Controllers\CartItemController::class, 'delete'])->where('id', '[0-9]+')->middleware('throttle:30,1');

    Route::get('/orders', [\App\Http\Controllers\OrderController::class, 'index'])->middleware('throttle:30,1');
    Route::post('/orders', [\App\Http\Controllers\OrderController::class, 'store'])->middleware('throttle:30,1');
    Route::get('/orders/{id}', [\App\Http\Controllers\OrderController::class, 'show'])->where('id', '[0-9]+')->middleware('throttle:30,1');

});

