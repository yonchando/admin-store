<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductOptionGroupController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PurchaseOrderController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\StaffController;
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

Route::middleware('auth')->group(function () {
    Route::get('/', DashboardController::class)->name('dashboard');

    Route::prefix('category')
        ->name('category.')
        ->group(function () {
            Route::get('/', [CategoryController::class, 'index'])->name('index');
            Route::post('/save', [CategoryController::class, 'store'])->name('store');
            Route::patch('update/{category}', [CategoryController::class, 'update'])->name('update');
            Route::delete('delete/{category}', [CategoryController::class, 'destroy'])->name('destroy');
        });

    Route::prefix('product')
        ->name('product.')
        ->group(function () {
            Route::get('/', [ProductController::class, 'index'])->name('index');
            Route::get('/show/{product}', [ProductController::class, 'show'])->name('show');

            Route::get('/create', [ProductController::class, 'create'])->name('create');
            Route::post('/save', [ProductController::class, 'store'])->name('store');

            Route::get('edit/{product}', [ProductController::class, 'edit'])->name('edit');
            Route::patch('update/{product}', [ProductController::class, 'update'])->name('update');
            Route::patch('update-status/{product}', [ProductController::class, 'updateStatus'])->name('update.status');

            Route::delete('destroy/{product}', [ProductController::class, 'destroy'])->name('destroy');
        });

    Route::prefix('product-option-group')
        ->name('product.option.group.')
        ->group(function () {
            Route::get('/', [ProductOptionGroupController::class, 'index'])->name('index');
            Route::post('/save', [ProductOptionGroupController::class, 'store'])->name('store');

            Route::patch('update/{productOptionGroup}', [
                ProductOptionGroupController::class, 'update',
            ])->name('update');

            Route::delete('delete/{productOptionGroup}', [
                ProductOptionGroupController::class, 'destroy',
            ])->name('destroy');
        });

    Route::prefix('purchase-order')
        ->name('purchase.order.')
        ->group(function () {
            Route::get('/', [PurchaseOrderController::class, 'index'])->name('index');
            Route::get('detail/{purchaseOrder}', [PurchaseOrderController::class, 'show'])->name('show');

            Route::patch('update-status/{purchaseOrder}',
                [PurchaseOrderController::class, 'updateStatus'])->name('update.status');
        });

    Route::prefix('customer')
        ->name('customer.')
        ->group(function () {
            Route::get('/', [CustomerController::class, 'index'])->name('index');
            Route::get('/show/{customer}', [CustomerController::class, 'show'])->name('show');
            Route::patch('update-status/{customer}', [CustomerController::class, 'updateStatus'])
                ->name('update.status');
        });

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::prefix('staff')
        ->name('staff.')
        ->group(function () {
            Route::get('/', [StaffController::class, 'index'])->name('index');
            Route::get('/show/{user}', [StaffController::class, 'show'])->name('show');

            Route::get('/create', [StaffController::class, 'create'])->name('create');
            Route::post('/save', [StaffController::class, 'store'])->name('store');

            Route::get('edit/{user}', [StaffController::class, 'edit'])->name('edit');
            Route::patch('update/{user}', [StaffController::class, 'update'])->name('update');
            Route::patch('update-status/{user}', [StaffController::class, 'updateStatus'])->name('update.status');

            Route::delete('destroy/{user}', [StaffController::class, 'destroy'])->name('destroy');

        });

    Route::prefix('setting')
        ->name('setting.')
        ->group(function () {
            Route::get('/', [SettingController::class, 'show'])->name('show');
            Route::put('update', [SettingController::class, 'update'])->name('update');
        });
});

require __DIR__.'/auth.php';
