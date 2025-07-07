<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Inventorycontroller;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\StockCheckInController;
use App\Http\Controllers\StockOutController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::group(['middleware' => 'auth'], function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('admin/profile', [AdminController::class, 'profile'])->name('admin.profile');

    Route::resource('product', ProductController::class);
    Route::get('product/status/{id}', [ProductController::class, 'status'])->name('product.status');

    Route::resource('customer', CustomerController::class);
    Route::get('customer/status/{id}', [CustomerController::class, 'status'])->name('customer.status');

    Route::resource('user', UserController::class);
    Route::get('user/status/{id}', [UserController::class, 'status'])->name('user.status');

    Route::resource('stockin', StockCheckInController::class);
    Route::get('stockin/status/{id}', [StockCheckInController::class, 'status'])->name('stockin.status');

    Route::resource('stockout', StockOutController::class);
    Route::get('stockout/status/{id}', [StockOutController::class, 'status'])->name('stockout.status');

    Route::resource('inventory', Inventorycontroller::class);
    Route::get('inventory/status/{id}', [Inventorycontroller::class, 'status'])->name('inventory.status');

});
