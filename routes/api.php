<?php

use App\Http\Controllers\API\AuthenticationController;
use App\Http\Controllers\API\CartController;
use App\Http\Controllers\API\DataController;
use App\Http\Controllers\API\PaymentController;

use App\Http\Controllers\OrderController;
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



Route::post('contact', [DataController::class, 'contact']);
Route::post('subscribe', [DataController::class, 'susbcribe']);

// Auth Routes for API
Route::post('register', [AuthenticationController::class, 'register']);
Route::post('login', [AuthenticationController::class, 'authenticate']);
Route::get('/logout', [AuthenticationController::class, 'logout']);
Route::get('/csrf-token', [AuthenticationController::class, 'csrf_token']);






// Table Routes
Route::get('tbl/{table_name}', [DataController::class, 'index']);
Route::get('tbl/{table_name}/{id}', [DataController::class, 'show']);
Route::post('tbl/{table_name}/create', [DataController::class, 'create']);
Route::post('tbl/{table_name}/delete/{id}', [DataController::class, 'delete']);
Route::post('tbl/{table_name}/update/{id}', [DataController::class, 'update']);


Route::group(['middleware' => 'auth:sanctum'], function () {
    // Cart Routes
    Route::get('cart/all-items', [CartController::class, 'getAllCartItems']);
    Route::post('cart/add-item', [CartController::class, 'addCartItem']);
    Route::post('cart/update-item/{id}', [CartController::class, 'updateCartItem']);
    Route::post('cart/delete-item/{id}', [CartController::class, 'removeCartItem']);

    // Order Routes
    Route::post('order/checkout', [OrderController::class, 'checkout']);

    // Payment Routes
    Route::post('payment/perform-payment/{id}', [PaymentController::class, 'performPayment']);
});




Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


