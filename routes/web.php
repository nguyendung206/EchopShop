<?php

use App\Http\Controllers\Web\AuthController;
use App\Http\Controllers\Web\FavoriteController;
use App\Http\Controllers\Web\HomeController;
use App\Http\Controllers\Web\ProductController;
use App\Http\Controllers\Web\ProfileUserController;
use Illuminate\Support\Facades\Route;

require __DIR__.'/admin.php';

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/exchangeProduct', [HomeController::class, 'filterProducts'])->name('exchangeProduct');
Route::get('/secondhandProduct', [HomeController::class, 'filterProducts'])->name('secondhandProduct');
Route::get('/giveawayProduct', [HomeController::class, 'filterProducts'])->name('giveawayProduct');
Route::get('/favoriteProduct', [HomeController::class, 'filterProducts'])->name('favoriteProduct');

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

Route::get('/logout', [AuthController::class, 'logout'])->name('web.logout');
Route::prefix('/product-detail')->group(function () {
    Route::get('/{slug}', [ProductController::class, 'show'])->name('web.productdetail.index');
});
Route::middleware(['auth:web'])->prefix('/')->group(function () {
    Route::prefix('/profile')->group(function () {
        Route::get('/{id}', [ProfileUserController::class, 'index'])->name('web.profile.index');
        Route::put('/save', [ProfileUserController::class, 'update'])->name('web.profile.save');
    });
});
Route::prefix('/favorite')->name('favorite.')->group(function () {
    Route::post('/', [FavoriteController::class, 'store'])->name('store');
    Route::delete('/{id}', [FavoriteController::class, 'destroy'])->name('destroy');
});
