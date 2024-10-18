<?php

use App\Http\Controllers\Web\AuthController;
use App\Http\Controllers\Web\CartController;
use App\Http\Controllers\Web\ContactController;
use App\Http\Controllers\Web\FavoriteController;
use App\Http\Controllers\Web\HomeController;
use App\Http\Controllers\web\NotificationController;
use App\Http\Controllers\Web\OrderController;
use App\Http\Controllers\Web\PolicyController;
use App\Http\Controllers\Web\ProductController;
use App\Http\Controllers\Web\ProfileUserController;
use App\Http\Controllers\Web\ShopController;
use Illuminate\Support\Facades\Route;

require __DIR__.'/admin.php';

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/list-product', [HomeController::class, 'filterProducts'])->name('listProducts');
Route::get('/favoriteProduct', [FavoriteController::class, 'index'])->name('favoriteProduct');
Route::get('/search', [HomeController::class, 'search'])->name('search');

Route::get('/login', [AuthController::class, 'index'])->name('web.login');
Route::post('/login', [AuthController::class, 'login'])->name('web.authentication');

Route::post('/register', [AuthController::class, 'store'])->name('web.register.store');
Route::get('/register', [AuthController::class, 'register'])->name('web.register');
Route::post('/district', [AuthController::class, 'getDistrict'])->name('web.district');
Route::post('/ward', [AuthController::class, 'getWard'])->name('web.ward');

Route::get('/forgotPassword', [AuthController::class, 'forgotPassword'])->name('web.forgotPassword');
Route::post('/forgotPassword', [AuthController::class, 'handleForgotPassword'])->name('web.handleForgotPassword'); // gửi mail
Route::get('/pinAuthentication/{token}', [AuthController::class, 'indexPinAuthentication'])->name('web.pinAuthentication');  // url bên mail
Route::post('/pinCode/{token}', [AuthController::class, 'checkPinCode'])->name('web.pinCode');
Route::post('/resetPassword/{token}', [AuthController::class, 'handleResetPassword'])->name('web.handleResetPassword');

Route::prefix('/product-detail')->group(function () {
    Route::get('/{slug}', [ProductController::class, 'show'])->name('web.productdetail.index');
});

Route::prefix('/about')->name('about.')->group(function () {
    Route::get('/contactUs', [ContactController::class, 'create'])->name('contactUs.create');
    Route::post('/contactUs', [ContactController::class, 'store'])->name('contactUs.store');
});

Route::prefix('/policy')->name('policy.')->group(function () {
    Route::get('/security', [PolicyController::class, 'getPolicy'])->name('security');
    Route::get('/term', [PolicyController::class, 'getPolicy'])->name('term');
    Route::get('/prohibited', [PolicyController::class, 'getPolicy'])->name('prohibited');
    Route::get('/communicate', [PolicyController::class, 'getPolicy'])->name('communicate');
    Route::get('/safeToUse', [PolicyController::class, 'getPolicy'])->name('safeToUse');
});

Route::middleware(['auth:web'])->prefix('/')->group(function () {
    Route::get('/logout', [AuthController::class, 'logout'])->name('web.logout');

    Route::prefix('/profile')->group(function () {
        Route::get('/{id}', [ProfileUserController::class, 'index'])->name('profile.index');
        Route::put('/saveprofile', [ProfileUserController::class, 'updateProfile'])->name('profile.save');
        Route::put('/saveidentification', [ProfileUserController::class, 'updateIdentification'])->name('identification.save');
    });
    Route::prefix('/registershop')->group(function () {
        Route::get('/', [ShopController::class, 'create'])->name('registershop.create');
        Route::post('/save', [ShopController::class, 'store'])->name('registershop.store');
    });

    Route::prefix('/favorite')->name('favorite.')->group(function () {
        Route::post('/', [FavoriteController::class, 'store'])->name('store');
        Route::delete('/{id}', [FavoriteController::class, 'destroy'])->name('destroy');
        Route::get('/count', [FavoriteController::class, 'getFavoriteCount'])->name('count');
    });

    Route::resource('/post', ProductController::class);
    Route::post('post/status/{id}', [ProductController::class, 'status'])->name('post.status');
    Route::post('/product/createwait', [ProductController::class, 'waitcreate'])->name('product.wait.create');

    Route::prefix('/cart')->name('cart.')->group(function () {
        Route::get('/', [CartController::class, 'index'])->name('index');
        Route::post('/store', [CartController::class, 'store'])->name('store');
        Route::post('/check', [CartController::class, 'check'])->name('check');
        Route::get('/destroy/{id}', [CartController::class, 'destroy'])->name('destroy');
        Route::get('/clear', [CartController::class, 'clear'])->name('clear');
        Route::put('/update-product-unit/{id}', [CartController::class, 'updateProductUnit'])->name('updateProductUnit');
        Route::put('/update-quantity-cart/{id}', [CartController::class, 'updateQuantityCart'])->name('updateQuantityCart');
        Route::post('/update/{id}', [CartController::class, 'update'])->name('update');
        Route::get('/count', [CartController::class, 'getCartCount'])->name('count');
    });

    Route::prefix('/order')->name('order.')->group(function () {
        Route::get('/', [OrderController::class, 'getCartsAndVouchers'])->name('index');
        Route::post('/change-address', [OrderController::class, 'changeAddress'])->name('changeAddress');
        Route::post('/pay-order', [OrderController::class, 'store'])->name('payOrder');
        Route::post('/cancel-order', [OrderController::class, 'updateStatusOrder'])->name('cancelOrder');
    });
    Route::get('/purchase', [OrderController::class, 'purchase'])->name('purchase');
    Route::get('/restore-cart/{id}' , [OrderController::class, 'restoreCart'])->name('restoreCart');
    
    Route::prefix('/notification')->name('notification.')->group(function () {
        Route::get('/isreaded/{id}', [NotificationController::class, 'isreaded'])->name('isreaded');
        Route::get('/all', [NotificationController::class, 'index'])->name('index');
        Route::get('/readall', [NotificationController::class, 'readall'])->name('readall');
        Route::get('/getnotification', [NotificationController::class, 'getNotifications'])->name('getnotification');
    });
});
