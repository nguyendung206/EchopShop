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
Route::get('/login', [AuthController::class, 'index'])->name('admin.login');
Route::post('/login', [AuthController::class, 'login'])->name('admin.login.post');

Route::middleware(['auth:admin'])->prefix('admin')->name('admin.')->group(function () {

    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/', [AuthController::class, 'index'])->name('index');
    Route::prefix('profile')->group(function () {
        Route::get('/{id}', [ProfileController::class, 'index'])->name('profile.index');
        Route::post('/save', [ProfileController::class, 'update'])->name('profile.save');
    });

    //category
    Route::resource('/category', CategoryController::class);
    Route::post('category/changestatus/{id}', [CategoryController::class, 'status'])->name('category.changestatus');

    //customer
    Route::resource('/customer', UserController::class);
    Route::put('customer/updateStatus/{id}', [UserController::class, 'updateStatus'])->name('customer.updateStatus');

    //partner
    Route::resource('/partner', PartnerController::class);
    Route::put('partner/updateStatus/{id}', [PartnerController::class, 'updateStatus'])->name('partner.updateStatus');

    //shop
    Route::resource('/shop', ShopController::class);
    Route::put('shop/changestatus/{id}', [ShopController::class, 'changestatus'])->name('shop.changestatus');

    //banner
    Route::resource('/banner', BannerController::class);
    Route::put('banner/updateStatus/{id}', [BannerController::class, 'updateStatus'])->name('banner.updateStatus');

    //banner
    Route::resource('/brand', BrandController::class);
    Route::put('brand/changestatus/{id}', [BrandController::class, 'changestatus'])->name('brand.changestatus');

    //banner
    Route::resource('/product', ProductController::class);
    Route::put('product/changestatus/{id}', [ProductController::class, 'changestatus'])->name('product.changestatus');

});
