<?php

use App\Http\Controllers\Website\Admin\DashboardController;
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

Route::group([
    'prefix' => LaravelLocalization::setLocale(),
    'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath']
], function () { 

    Route::get('/', function () {
        return view('welcome');
    });
    
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->middleware(['auth', 'verified'])->name('dashboard');
    
    Route::prefix('admin')->middleware(['auth', 'user_type:admin'])->namespace('Website\Admin')->name('admin.')->group(function() {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    });

    require __DIR__.'/admin_auth.php';
    require __DIR__.'/auth.php';
});