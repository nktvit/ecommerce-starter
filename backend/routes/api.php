<?php

use App\Http\Controllers\OrdersController;
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
});
