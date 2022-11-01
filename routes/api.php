<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProfileController;
use Illuminate\Http\Request;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::name('api.')->namespace('Api')->group(function() {
    Route::post('login', [AuthController::class, 'login'])->name('login');
    Route::post('login/cashier', [AuthController::class, 'cashierLogin'])->name('login.cashier');
    
    Route::post('register', [AuthController::class, 'register'])->name('register');

    Route::middleware(['auth:api'])->group(function() {
            Route::post('userinfo/{userId}', [ProfileController::class, 'userInfo'])->name('userInfo');
            Route::post('edituserInfo/{userId}', [ProfileController::class, 'EditUserInfo'])->name('userInfo');
    });
});

