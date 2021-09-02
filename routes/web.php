<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\TableDataController;
use App\Http\Controllers\TableController;
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
    Route::get('/',  [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/dashboard',  [AdminController::class, 'index'])->name('admin.dashboard');

    Route::get('/manage/{table_name}/add',  [TableDataController::class, 'add_entry'])->name('admin.add_entry');
    Route::post('/manage/{table_name}/create',  [TableDataController::class, 'create_entry'])->name('admin.create_entry');
    Route::get('/manage/{table_name}',  [TableDataController::class, 'manage'])->name('admin.manage');
    Route::post('/manage/{table_name}/delete/{id}',  [TableDataController::class, 'delete_item'])->name('admin.delete_item');
    Route::get('/manage/{table_name}/edit/{id}',  [TableDataController::class, 'edit_item'])->name('admin.edit_item');
    Route::post('/manage/{table_name}/update/{id}',  [TableDataController::class, 'update_item'])->name('admin.update_item');

    Route::get('/tables',  [TableController::class, 'index'])->name('admin.tables');
    Route::get('/tables/{table}/fields',  [TableController::class, 'fields'])->name('admin.tables.fields');
    Route::get('/tables/{id}',  [TableController::class, 'details'])->name('admin.tables.detail');
    Route::post('/tables/update/{id}',  [TableController::class, 'update'])->name('admin.tables.update');
    Route::post('/tables/delete/{id}',  [TableController::class, 'delete'])->name('admin.tables.delete');
    Route::post('/tables/create',  [TableController::class, 'create'])->name('admin.tables.create');
});



require __DIR__.'/auth.php';
