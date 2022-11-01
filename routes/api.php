<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\FavouriteController;
use App\Http\Controllers\Api\LoyaltyController;
use App\Http\Controllers\Api\MenuController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\AddressesController;
use App\Http\Controllers\Api\OfferController;
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


Route::name('api.')->group(function () {
    Route::post('login', [AuthController::class, 'login'])->name('login');
    Route::post('login/cashier', [AuthController::class, 'cashierLogin'])->name('login.cashier');

    Route::post('register', [AuthController::class, 'register'])->name('register');

    Route::prefix('menu')->group(function () {
        Route::get('categories', [MenuController::class, 'categories'])->name('categories');
        Route::get('categories/{category}', [MenuController::class, 'categoryProducts'])->name('categories.products');

        Route::get('{product}', [MenuController::class, 'productDetails'])->name('product.details');
    });

    Route::prefix('offer')->group(function () {
        Route::get('categories', [OfferController::class, 'categories'])->name('categories');
        Route::get('categories/{category}', [OfferController::class, 'categoryProducts'])->name('categories.products');
    });

    Route::middleware(['auth:api'])->group(function () {
        Route::resource('favourites', FavouriteController::class)->only(['index', 'store', 'delete']);

        Route::post('userinfo/{userId}', [ProfileController::class, 'userInfo'])->name('userInfo');
        Route::post('edituserInfo/{userId}', [ProfileController::class, 'EditUserInfo'])->name('userInfo');
        Route::get('address/store', [AddressesController::class, 'store'])->name('CreateAddress');
        Route::post('address/update/{address_id}', [AddressesController::class, 'update'])->name('updateAddress');
        Route::post('address/destroy/{address_id}', [AddressesController::class, 'destroy'])->name('destroyAddress');

        Route::prefix('points')->controller(LoyaltyController::class)->name('points.')->group(function () {
            Route::get('', 'index')->name('index');
            Route::get('history', 'history')->name('history');
            Route::get('screen', 'screen')->name('screen');
        });
    });
});
