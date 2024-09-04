<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\AuthController;
use App\Http\Controllers\Web\HomeController;

require __DIR__ . '/admin.php';
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

// Route::get('/', function () {

//     return view('welcome');
// });
Route::get('/',[HomeController::class, 'index']);
Route::get('/getBrand', [HomeController::class, 'getBrand'])->name('web.getBrand');

Route::get('/web/login', [AuthController::class, 'index'])->name('web.login');
Route::post('/web/login', [AuthController::class, 'login'])->name('web.authentication');

Route::post('/web/register', [AuthController::class, 'store'])->name('web.register.store');
Route::get('/web/register', [AuthController::class, 'register'])->name('web.register');
Route::post('/web/district', [AuthController::class, 'getDistrict'])->name('web.district');
Route::post('/web/ward', [AuthController::class, 'getWard'])->name('web.ward');

Route::get('/web/forgotPassword', [AuthController::class, 'forgotPassword'])->name('web.forgotPassword');
Route::post('/web/forgotPassword', [AuthController::class, 'handleForgotPassword'])->name('web.handleForgotPassword');
Route::get('/web/ResetPassword/{token}', [AuthController::class, 'resetPassword'])->name('web.resetPassword');
Route::post('/web/ResetPassword/{token}', [AuthController::class, 'handleResetPassword'])->name('web.handleResetPassword');