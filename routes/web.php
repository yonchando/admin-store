<?php

use App\Http\Controllers\CardController;
use App\Http\Controllers\Category\CategoryController;
use App\Http\Controllers\Customer\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Option\OptionController;
use App\Http\Controllers\Option\OptionGroupController;
use App\Http\Controllers\Product\ProductController;
use App\Http\Controllers\Product\ProductGroupOptionController;
use App\Http\Controllers\Product\ProductOptionController;
use App\Http\Controllers\Profile\ProfileController;
use App\Http\Controllers\Purchase\PurchaseOrderController;
use App\Http\Controllers\Setting\SettingController;
use App\Http\Controllers\Staff\StaffController;
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
            Route::delete('delete/{category}', [CategoryController::class, 'destroy'])->name('destroy');
        });

    Route::prefix('product')
        ->name('product.')
        ->group(function () {
            Route::get('/', [ProductController::class, 'index'])->name('index');
            Route::get('/show/{product}', [ProductController::class, 'show'])->name('show');

            Route::get('/create', [ProductController::class, 'create'])->name('create');
            Route::post('store', [ProductController::class, 'store'])->name('store');

            Route::post('add-product-option/{product}', [
                ProductGroupOptionController::class, 'store',
            ])->name('store.product.option');

            Route::post('/{product}/add-option', [
                ProductOptionController::class, 'store',
            ])->name('add.option');

            Route::get('edit/{product:slug}', [ProductController::class, 'edit'])->name('edit');
            Route::put('update/{product:slug}', [ProductController::class, 'update'])->name('update');
            Route::put('update-status/{id}', [ProductController::class, 'updateStatus'])->name(
                'update.status'
            );

            Route::delete('destroy/{product}', [ProductController::class, 'destroy'])->name('destroy');
            Route::delete(
                'destroy-option-group/{productHasOptionGroup}',
                [ProductGroupOptionController::class, 'destroy']
            )->name('destroy.product.option.group');
            Route::delete(
                'destroy-option/{productHasOption}',
                [ProductController::class, 'destroyProductOption']
            )->name('destroy.product.option');
        });

    Route::prefix('product-option')
        ->name('product.option.')
        ->group(function () {
            Route::get('/', [OptionController::class, 'index'])->name('index');

            Route::post('store', [OptionController::class, 'store'])->name('store');

            Route::post('store-many', [OptionController::class, 'storeMany'])->name('store.many');

            Route::put('update/{productOption}', [
                OptionController::class, 'update',
            ])->name('update');

            Route::delete('delete/{productOption}', [
                OptionController::class, 'destroy',
            ])->name('destroy');

            Route::delete('delete-multiple', [
                OptionController::class, 'destroyMany',
            ])->name('destroy.many');
        });

    Route::prefix('product-option-group')
        ->name('product.option.group.')
        ->group(function () {
            Route::get('/', [OptionGroupController::class, 'index'])->name('index');

            Route::post('/save', [OptionGroupController::class, 'store'])->name('store');

            Route::put('update/{productOptionGroup}', [
                OptionGroupController::class, 'update',
            ])->name('update');

            Route::delete('delete/{productOptionGroup}', [
                OptionGroupController::class, 'destroy',
            ])->name('destroy');
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
        ->group(function(){
            Route::get('/','index')->name('index');
            Route::get('/{card}','show')->name('show');

            Route::get('create','create')->name('create');
            Route::post('store','store')->name('store');

            Route::get('edit/{card}','edit')->name('edit');
            Route::put('update/{card}','update')->name('update');

            Route::get('destroy/{card}','destroy')->name('destroy');
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
