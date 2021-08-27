<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CollectionsController;
use App\Http\Controllers\ContentTypeController;
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
    Route::get('/manage/{table_name}',  [CollectionsController::class, 'manage'])->name('admin.manage');
    Route::get('/manage/{table_name}/delete/{id}',  [CollectionsController::class, 'delete_item'])->name('admin.delete_item');
    Route::get('/manage/{table_name}/edit/{id}',  [CollectionsController::class, 'edit_item'])->name('admin.edit_item');

    Route::get('/content-types',  [ContentTypeController::class, 'index'])->name('admin.content-types');
    Route::get('/content-types/{id}',  [ContentTypeController::class, 'details'])->name('admin.content-types.detail');
    Route::post('/content-types/create',  [ContentTypeController::class, 'create'])->name('admin.content-types.create');
});



require __DIR__.'/auth.php';
