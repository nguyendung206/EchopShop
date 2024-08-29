<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\UserController;

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
        Route::get('/{id}', [ProfileController::class, 'Index'])->name('profile.index');
        Route::post('/save', [ProfileController::class, 'Save'])->name('profile.save');
    });
    Route::prefix('category')->group(function () {
        Route::get('/', [CategoryController::class, 'Index'])->name('category.index');
        Route::get('add', [CategoryController::class, 'Create'])->name('category.add');
        Route::post('add', [CategoryController::class, 'SaveCreate'])->name('category.add.save');
        Route::get('/update/{id}', [CategoryController::class, 'Update'])->name('category.update');
        Route::post('/update/{id}', [CategoryController::class, 'SaveUpdate'])->name('category.update.save');
        Route::delete('/delete/{id}', [CategoryController::class, 'Delete'])->name('category.delete');
        Route::get('/changestatus/{id}', [CategoryController::class, 'Status'])->name('category.changestatus');
    });
    Route::prefix('brand')->group(function () {
        Route::get('/', [BrandController::class, 'Index'])->name('brand.index');
        Route::get('add', [BrandController::class, 'Create'])->name('brand.add');
        Route::post('add', [BrandController::class, 'SaveCreate'])->name('brand.add.save');
        Route::get('/update/{id}', [BrandController::class, 'Update'])->name('brand.update');
        Route::post('/update/{id}', [BrandController::class, 'SaveUpdate'])->name('brand.update.save');
        Route::delete('/delete/{id}', [BrandController::class, 'Delete'])->name('brand.delete');
        Route::get('/changestatus/{id}', [BrandController::class, 'Status'])->name('brand.changestatus');
    });

    Route::prefix('product')->group(function () {
        Route::get('/', [ProductController::class, 'Index'])->name('product.index');
        Route::get('add', [ProductController::class, 'Create'])->name('product.add');
        Route::post('add', [ProductController::class, 'SaveCreate'])->name('product.add.save');
        Route::get('/update/{id}', [ProductController::class, 'Update'])->name('product.update');
        Route::post('/update/{id}', [ProductController::class, 'SaveUpdate'])->name('product.update.save');
        Route::delete('/delete/{id}', [ProductController::class, 'Delete'])->name('product.delete');
        Route::get('/changestatus/{id}', [ProductController::class, 'Status'])->name('product.changestatus');
    });
    Route::prefix('/manager-user')->group(function () {
        Route::get('/create', [UserController::class, 'create'])->name('manager-user.create');
        Route::post('/', [UserController::class, 'store'])->name('manager-user.store');
        Route::get('/', [UserController::class, 'index'])->name('manager-user.index');
        Route::get('/{id}', [UserController::class, 'show'])->name('manager-user.show');
        Route::get('/update/{id}/edit', [UserController::class, 'edit'])->name('manager-user.edit');
        Route::put('/updateStatus/{id}', [UserController::class, 'updateStatus'])->name('manager-user.updateStatus');
        Route::put('/update/{id}', [UserController::class, 'update'])->name('manager-user.update');
        Route::delete('/{id}', [UserController::class, 'destroy'])->name('manager-user.destroy');
    });
});
