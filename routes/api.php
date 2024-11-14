<?php

use App\Http\Controllers\Api\ProfileUserController;
use App\Http\Controllers\Web\AuthController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/login', [AuthController::class, 'login']);
Route::post('/forgotPassword', [AuthController::class, 'forgotPassword']);
Route::post('/checkPin', [AuthController::class, 'checkPinCode'])->name('api.checkPin');
Route::post('/resetPassword', [AuthController::class, 'resetPassword'])->name('api.resetPassword')->middleware('signed.json');

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/me', [AuthController::class, 'me']);
    Route::get('/logout', [AuthController::class, 'logout']);

    // Profile
    Route::put('/profile', [ProfileUserController::class, 'updateProfile']);
    Route::put('/identification', [ProfileUserController::class, 'updateIdentification']);
});
