<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrdersController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::group(['middleware' => ['auth:sanctum']], static function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });


    Route::get('/orders', [OrdersController::class, 'index']);
    Route::get('/order/{id}', [OrdersController::class, 'show']);
    Route::post('/order/delete/{id}', [OrdersController::class, 'destroy']);

    Route::post('/product/create', [ProductsController::class, 'store']);
    Route::post('/product/update', [ProductsController::class, 'update']);
    Route::post('/product/delete/{id}', [ProductsController::class, 'destroy']);

    Route::get('/cart/{id}', [CartController::class, 'index']);
    Route::post('/cart/add', [CartController::class, 'addItem']);
    Route::post('/cart/change-item-quantity', [CartController::class, 'update']);
    Route::post('/cart/delete-item/{id}', [CartController::class, 'deleteItem']);
    Route::post('/cart/delete-all/{id}', [CartController::class, 'deleteAllCart']);

    Route::post('/user/create/billing-and-shipping', [UserController::class, 'createShippingAndBillingAddress']);
    Route::post('/user/create/shipping', [UserController::class, 'createShippingAddress']);
    Route::post('/user/create/billing', [UserController::class, 'createBillingAddress']);
    Route::post('/user/update/shipping', [UserController::class, 'updateShippingAddress']);
    Route::post('/user/update/billing', [UserController::class, 'updateBillingAddress']);

    Route::post('/checkout/user', [CheckoutController::class, 'storeUser']);
});

Route::get('/products', [ProductsController::class, 'index']);
Route::get('/product/{slug}', [ProductsController::class, 'show']);

Route::post('/checkout/guest', [CheckoutController::class, 'storeGuest']);
