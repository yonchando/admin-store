<?php

use App\Http\Controllers\CardController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
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
            Route::post('store', [CategoryController::class, 'store'])->name('store');
            Route::put('update/{category}', [CategoryController::class, 'update'])->name('update');
            Route::delete('delete', [CategoryController::class, 'destroy'])->name('destroy');
        });

    Route::prefix('product')
        ->name('product.')
        ->group(function () {
            Route::get('/', [ProductController::class, 'index'])->name('index');
            Route::get('/show/{id}', [ProductController::class, 'show'])->name('show');

            Route::get('/create', [ProductController::class, 'create'])->name('create');
            Route::post('store', [ProductController::class, 'store'])->name('store');

            Route::get('edit/{id}', [ProductController::class, 'edit'])->name('edit');
            Route::put('update/{id}', [ProductController::class, 'update'])->name('update');
            Route::put('update-status/{id}', [ProductController::class, 'updateStatus'])
                ->name('update.status');

            Route::delete('destroy', [ProductController::class, 'destroy'])->name('destroy');
        });

    Route::prefix('purchase-order')
        ->name('purchase.order.')
        ->group(function () {
            Route::get('/', [PurchaseOrderController::class, 'index'])->name('index');
            Route::get('detail/{purchaseOrder}', [PurchaseOrderController::class, 'show'])->name('show');

            Route::put(
                'update-status/{purchaseOrder}',
                [PurchaseOrderController::class, 'updateStatus']
            )->name('update.status');
        });

    Route::prefix('customer')
        ->name('customer.')
        ->group(function () {
            Route::get('/', [CustomerController::class, 'index'])->name('index');
            Route::get('/show/{customer}', [CustomerController::class, 'show'])->name('show');
            Route::put('update-status/{customer}', [CustomerController::class, 'updateStatus'])
                ->name('update.status');
        });

    Route::prefix('card')
        ->name('card.')
        ->controller(CardController::class)
        ->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('show/{card}', 'show')->name('show');

            Route::get('create', 'create')->name('create');
            Route::post('store', 'store')->name('store');

            Route::get('edit/{card}', 'edit')->name('edit');
            Route::put('update/{card}', 'update')->name('update');

            Route::delete('destroy/{card}', 'destroy')->name('destroy');
        });

    Route::get('profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::prefix('staff')
        ->name('staff.')
        ->group(function () {
            Route::get('/', [StaffController::class, 'index'])->name('index');
            Route::get('/show/{user}', [StaffController::class, 'show'])->name('show');

            Route::get('/create', [StaffController::class, 'create'])->name('create');
            Route::post('/save', [StaffController::class, 'store'])->name('store');

            Route::get('edit/{user}', [StaffController::class, 'edit'])->name('edit');
            Route::put('update/{user}', [StaffController::class, 'update'])->name('update');
            Route::put('update-status/{user}', [StaffController::class, 'updateStatus'])->name('update.status');

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
