<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminUserManagerController;

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

Route::prefix('/admin')->group(function () {

    Route::get('/list-users', [AdminUserManagerController::class, 'listUsers'])->name('list.user');
    Route::get('/get-user/{id}', [AdminUserManagerController::class, 'getUser'])->name('get.user');

    Route::get('/add-user', [AdminUserManagerController::class, 'addUserForm'])->name('add.user');
    Route::post('/add-user', [AdminUserManagerController::class, 'handleAddUser']);

    Route::get('/update-user/{id}', [AdminUserManagerController::class, 'updateUser'])->name('update.user');
    Route::put('/update-user/{id}', [AdminUserManagerController::class, 'handleUpdateUser']);

    Route::delete('/delete-user/{id}', [AdminUserManagerController::class, 'deleteUser']);
});
