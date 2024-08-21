<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\CategoryController;

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


Route::get('/login', [AuthController::class, 'Index'])->name('admin.login');
Route::post('/login', [AuthController::class, 'Login'])->name('login');
Route::get('/logout', [AuthController::class, 'Logout'])->name('logout');

Route::middleware(['auth:admin'])->prefix('admin')->group(function () {
    Route::get('/', [AuthController::class, 'Index'])->name('admin.index');
    Route::prefix('profile')->group(function () {
        Route::get('/{Id}', [ProfileController::class, 'Index'])->name('profile.index');
        Route::post('/save', [ProfileController::class, 'Save'])->name('profile.save');
    });
    Route::prefix('category')->group(function () {
        Route::get('/', [CategoryController::class, 'Index'])->name('category.index');
        Route::get('add', [CategoryController::class, 'Create'])->name('category.add');
        Route::post('add', [CategoryController::class, 'Save'])->name('category.save');
        Route::get('/edit/{id}', [CategoryController::class, 'Edit'])->name('category.edit');
        Route::get('/delete/{id}', [CategoryController::class, 'showDeleteForm'])->name('category.delete');
        Route::post('/delete/{id}', [CategoryController::class, 'delete'])->name('deletecategory.post');
    });
});
