<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\TableDataController;
use App\Http\Controllers\TableController;
use App\Http\Controllers\CustomActionController;
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



// Admin Routes
Route::group(['middleware' => ['auth', 'role:admin']], function () {
    Route::get('/',  [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/dashboard',  [AdminController::class, 'index'])->name('admin.dashboard');

    Route::get('/manage/{table_name}/add',  [TableDataController::class, 'add_entry'])->name('admin.add_entry');
    Route::post('/manage/{table_name}/create',  [TableDataController::class, 'create_entry'])->name('admin.create_entry');
    Route::get('/manage/{id}',  [TableDataController::class, 'manage'])->name('admin.manage');
    Route::post('/manage/{table_name}/delete/{id}',  [TableDataController::class, 'delete_item'])->name('admin.delete_item');
    Route::get('/manage/{table_name}/edit/{id}',  [TableDataController::class, 'edit_item'])->name('admin.edit_item');
    Route::post('/manage/{table_name}/update/{id}',  [TableDataController::class, 'update_item'])->name('admin.update_item');
    Route::post('/manage/{table_name}/export',  [TableDataController::class, 'export_data'])->name('admin.export_table');
    Route::post('/manage/{table_name}/import',  [TableDataController::class, 'import_data'])->name('admin.import_table');

    Route::get('/tables',  [TableController::class, 'index'])->name('admin.tables');
    Route::get('/all-tables',  [TableController::class, 'get_all_tables'])->name('admin.tables.all');
    Route::post('/tables/{table}/rename',  [TableController::class, 'rename_table'])->name('admin.tables.rename');
    Route::get('/tables/{table}/fields',  [TableController::class, 'fields'])->name('admin.tables.fields');
    Route::get('/tables/{id}',  [TableController::class, 'details'])->name('admin.tables.detail');
    Route::post('/tables/update/{id}',  [TableController::class, 'update'])->name('admin.tables.update');
    Route::post('/tables/delete/{id}',  [TableController::class, 'delete'])->name('admin.tables.delete');
    Route::post('/tables/create',  [TableController::class, 'create'])->name('admin.tables.create');

    // General Settings
    Route::get('/settings',  [SettingsController::class, 'index'])->name('admin.settings');
    Route::get('/payments',  [SettingsController::class, 'payments'])->name('admin.settings.payments');

    // Role Settings
    Route::get('/roles',  [RoleController::class, 'roles'])->name('admin.settings.roles');
    Route::post('/create-role',  [RoleController::class, 'create_role'])->name('admin.settings.create_role');
    Route::post('/save-settings',  [SettingsController::class, 'save_settings'])->name('admin.settings.save');

    // Email Settings
    Route::get('/email',  [EmailController::class, 'index'])->name('admin.settings.email');
    Route::post('/save-email-settings',  [EmailController::class, 'save_email_settings'])->name('admin.settings.save_email');

    // Custom Action
    Route::get('/actions/{table}',  [CustomActionController::class, 'get_actions'])->name('admin.actions.get_action');
    Route::post('/actions/{action}/{table}/{id}',  [CustomActionController::class, 'trigger_action'])->name('admin.actions.create');
});



require __DIR__.'/auth.php';
