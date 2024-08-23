<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;
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

    Route::prefix('/manager-user')->group(function () {

        Route::get('/create', [UserController::class, 'create'])->name('manager-user.create');
        Route::post('/', [UserController::class, 'store'])->name('manager-user.store');

        Route::get('/', [UserController::class, 'index'])->name('manager-user.index');
        Route::get('/{id}', [UserController::class, 'show'])->name('manager-user.show');
    
        Route::get('/update/{id}/edit', [UserController::class, 'edit'])->name('manager-user.edit');
        Route::put('/update/{id}', [UserController::class, 'update'])->name('manager-user.update');
    
        Route::delete('/{id}', [UserController::class, 'destroy'])->name('manager-user.destroy');
    });
});
