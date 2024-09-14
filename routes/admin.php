<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\PartnerController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\ShopController;
use App\Http\Controllers\Admin\UserController;
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

Route::get('admin/login', [AuthController::class, 'Index'])->name('admin.login');
Route::post('admin/login', [AuthController::class, 'Login'])->name('admin.login');
Route::get('admin/logout', [AuthController::class, 'Logout'])->name('admin.logout');

Route::middleware(['auth:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AuthController::class, 'index'])->name('index');
    Route::prefix('profile')->group(function () {
        Route::get('/{id}', [ProfileController::class, 'index'])->name('profile.index');
        Route::post('/save', [ProfileController::class, 'update'])->name('profile.save');
    });

    //category
    Route::resource('/category', CategoryController::class);
    Route::get('category/changestatus/{id}', [CategoryController::class, 'status'])->name('category.changestatus');

    //customer
    Route::resource('/customer', UserController::class);
    Route::put('customer/updateStatus/{id}', [UserController::class, 'updateStatus'])->name('customer.updateStatus');

    //partner
    Route::resource('/partner', PartnerController::class);
    Route::put('partner/updateStatus/{id}', [PartnerController::class, 'updateStatus'])->name('partner.updateStatus');

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

    Route::prefix('/banner')->name('banner.')->group(function () {
        Route::get('/create', [BannerController::class, 'create'])->name('create');
        Route::post('/', [BannerController::class, 'store'])->name('store');
        Route::get('/', [BannerController::class, 'index'])->name('index');
        Route::get('/{id}', [BannerController::class, 'show'])->name('show');
        Route::get('/update/{id}/edit', [BannerController::class, 'edit'])->name('edit');
        Route::put('/updateStatus/{id}', [BannerController::class, 'updateStatus'])->name('updateStatus');
        Route::put('/update/{id}', [BannerController::class, 'update'])->name('update');
        Route::delete('/{id}', [BannerController::class, 'destroy'])->name('destroy');
    });

    // Route::prefix('/partner')->name('partner.')->group(function () {
    //     Route::get('/create', [PartnerController::class, 'create'])->name('create');
    //     Route::post('/', [PartnerController::class, 'store'])->name('store');
    //     Route::get('/', [PartnerController::class, 'index'])->name('index');
    //     Route::get('/{id}', [PartnerController::class, 'show'])->name('show');
    //     Route::get('/update/{id}/edit', [PartnerController::class, 'edit'])->name('edit');
    //     Route::put('/updateStatus/{id}', [PartnerController::class, 'updateStatus'])->name('updateStatus');
    //     Route::put('/update/{id}', [PartnerController::class, 'update'])->name('update');
    //     Route::delete('/{id}', [PartnerController::class, 'destroy'])->name('destroy');
    // });

    Route::prefix('shop')->group(function () {
        Route::get('/', [ShopController::class, 'index'])->name('shop.index');
        Route::get('/{id}', [ShopController::class, 'show'])->name('shop.show');
        Route::get('/changestatus/{id}', [ShopController::class, 'status'])->name('shop.changestatus');
    });
});
