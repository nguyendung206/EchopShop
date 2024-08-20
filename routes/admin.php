<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;

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
});
