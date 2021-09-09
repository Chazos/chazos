<?php

use App\Http\Controllers\API\AuthenticationController;
use App\Http\Controllers\API\DataController;
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

Route::post('register', [AuthenticationController::class, 'register']);
Route::post('login', [AuthenticationController::class, 'authenticate']);
Route::get('/logout', [AuthenticationController::class, 'logout']);


Route::get('tbl/{table_name}', [DataController::class, 'index']);
Route::get('tbl/{table_name}/{id}', [DataController::class, 'show']);
Route::post('tbl/{table_name}/delete/{id}', [DataController::class, 'delete']);




Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


