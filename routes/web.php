<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\TestController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


    Route::get('/dashboard',  function () {
        return view('welcome');
    })->name('admin.dashboard');







Route::get('/test-database', [TestController::class, 'test_database'])->name('home');




// Admin Routes
Route::group(['middleware' => ['auth', 'role:admin']], function () {
    Route::get('/dashboard',  [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/manage/{table_name}',  [AdminController::class, 'manage'])->name('admin.manage');
});



require __DIR__.'/auth.php';
