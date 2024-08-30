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


Route::get('/login', [AuthController::class, 'index'])->name('admin.login');
Route::post('/login', [AuthController::class, 'Login'])->name('login');
Route::get('/logout', [AuthController::class, 'Logout'])->name('logout');

Route::middleware(['auth:admin'])->prefix('admin')->group(function () {
    Route::get('/', [AuthController::class, 'index'])->name('admin.index');
    Route::prefix('profile')->group(function () {
        Route::get('/{id}', [ProfileController::class, 'index'])->name('profile.index');
        Route::post('/save', [ProfileController::class, 'update'])->name('profile.save');
    });
    Route::prefix('category')->group(function () {
        Route::get('/', [CategoryController::class, 'index'])->name('category.index');
        Route::get('add', [CategoryController::class, 'create'])->name('category.add');
        Route::post('add', [CategoryController::class, 'store'])->name('category.add.save');
        Route::get('/edit/{id}', [CategoryController::class, 'edit'])->name('category.edit');
        Route::post('/edit/{id}', [CategoryController::class, 'update'])->name('category.edit.save');
        Route::delete('/delete/{id}', [CategoryController::class, 'destroy'])->name('category.delete');
        Route::get('/changestatus/{id}', [CategoryController::class, 'status'])->name('category.changestatus');
    });
    Route::prefix('brand')->group(function () {
        Route::get('/', [BrandController::class, 'index'])->name('brand.index');
        Route::get('add', [BrandController::class, 'create'])->name('brand.add');
        Route::post('add', [BrandController::class, 'store'])->name('brand.add.save');
        Route::get('/edit/{id}', [BrandController::class, 'edit'])->name('brand.edit');
        Route::post('/edit/{id}', [BrandController::class, 'update'])->name('brand.edit.save');
        Route::delete('/delete/{id}', [BrandController::class, 'destroy'])->name('brand.delete');
        Route::get('/changestatus/{id}', [BrandController::class, 'status'])->name('brand.changestatus');
    });

    Route::prefix('product')->group(function () {
        Route::get('/', [ProductController::class, 'index'])->name('product.index');
        Route::get('add', [ProductController::class, 'create'])->name('product.add');
        Route::post('add', [ProductController::class, 'store'])->name('product.add.save');
        Route::get('/edit/{id}', [ProductController::class, 'edit'])->name('product.edit');
        Route::post('/edit/{id}', [ProductController::class, 'update'])->name('product.edit.save');
        Route::delete('/delete/{id}', [ProductController::class, 'destroy'])->name('product.delete');
        Route::get('/changestatus/{id}', [ProductController::class, 'status'])->name('product.changestatus');
        Route::get('/show/{id}', [ProductController::class, 'show'])->name('product.show');
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
