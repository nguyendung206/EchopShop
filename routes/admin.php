<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ContactController;
use App\Http\Controllers\Admin\DiscountController;
use App\Http\Controllers\admin\FeeshipController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\PartnerController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\ShopController;
use App\Http\Controllers\Admin\StaticContentController;
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

Route::get('/admin/login', [AuthController::class, 'index'])->name('admin.login');
Route::post('/admin/login', [AuthController::class, 'login'])->name('admin.login');
Route::get('/admin/logout', [AuthController::class, 'logout'])->name('admin.logout');

Route::middleware(['auth:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AuthController::class, 'index'])->name('index');
    Route::prefix('profile')->group(function () {
        Route::get('/{id}', [ProfileController::class, 'index'])->name('profile.index');
        Route::post('/save', [ProfileController::class, 'update'])->name('profile.save');
    });

    //discount
    Route::resource('/discount', DiscountController::class);
    Route::put('discount/changeStatus/{id}', [DiscountController::class, 'changeStatus'])->name('discount.changeStatus');
    Route::get('/getDiscountJson', [DiscountController::class, 'getDiscountJson'])->name('discount.getDiscountJson');

    //contact
    Route::prefix('contact')->name('contact.')->group(function () {
        Route::get('/', [ContactController::class, 'index'])->name('index');
        Route::get('/{id}', [ContactController::class, 'show'])->name('show');
        Route::delete('/{id}', [ContactController::class, 'destroy'])->name('destroy');
        Route::post('/sendMail', [ContactController::class, 'sendMail'])->name('sendMail');
    });
    //static content
    Route::resource('/static-content', StaticContentController::class);
    Route::put('static-content/changeStatus/{id}', [StaticContentController::class, 'changeStatus'])->name('static-content.changeStatus');

    //category
    Route::post('/category/import', [CategoryController::class, 'import'])->name('category.import');
    Route::resource('/category', CategoryController::class);
    Route::post('category/changestatus/{id}', [CategoryController::class, 'status'])->name('category.changestatus');

    //customer
    Route::resource('/customer', UserController::class);
    Route::put('customer/changeStatus/{id}', [UserController::class, 'changeStatus'])->name('customer.changeStatus');

    //partner
    Route::resource('/partner', PartnerController::class);
    Route::put('partner/changeStatus/{id}', [PartnerController::class, 'changeStatus'])->name('partner.changeStatus');

    //shop
    Route::resource('/shop', ShopController::class);
    Route::post('shop/changestatus/{id}', [ShopController::class, 'status'])->name('shop.changestatus');

    //banner
    Route::resource('/banner', BannerController::class);
    Route::put('banner/changeStatus/{id}', [BannerController::class, 'changeStatus'])->name('banner.changeStatus');

    //brand
    Route::post('/brand/import', [BrandController::class, 'import'])->name('brand.import');
    Route::resource('/brand', BrandController::class);
    Route::post('brand/changestatus/{id}', [BrandController::class, 'status'])->name('brand.changestatus');

    //product
    Route::post('/product/import', [ProductController::class, 'import'])->name('product.import');
    Route::resource('/product', ProductController::class);
    Route::post('product/changestatus/{id}', [ProductController::class, 'status'])->name('product.changestatus');

    Route::prefix('userproduct')->name('userproduct.')->group(function () {
        Route::get('/', [ProductController::class, 'userproduct'])->name('index');
        Route::get('/show/{id}', [ProductController::class, 'showuserproduct'])->name('show');
        Route::post('/changestatus/{id}', [ProductController::class, 'statususerproduct'])->name('changestatus');
    });

    Route::prefix('wait')->name('wait.')->group(function () {
        Route::get('/', [ProductController::class, 'wait'])->name('index');
        Route::get('/show/{id}', [ProductController::class, 'waitshow'])->name('show');
        Route::post('/reject', [ProductController::class, 'reject'])->name('reject');
        Route::post('/accept', [ProductController::class, 'accept'])->name('accept');
    });

    Route::prefix('order')->name('order.')->group(function () {
        Route::get('/', [OrderController::class, 'index'])->name('index');
        Route::get('/create', [OrderController::class, 'create'])->name('create');
        Route::post('/store', [OrderController::class, 'store'])->name('store');
        Route::get('/{order}', [OrderController::class, 'show'])->name('show');
        Route::post('/updateStatus/{id}', [OrderController::class, 'updateStatus'])->name('updateStatus');
        Route::post('/order/import', [OrderController::class, 'import'])->name('import');

    });

    //Feeship
    Route::resource('/feeship', FeeshipController::class);

    //select address
    Route::post('/select-feeship', [FeeshipController::class, 'selectAddress'])->name('selectAddress');
    Route::get('/get-wards', [FeeshipController::class, 'getWards'])->name('getWards');
});
