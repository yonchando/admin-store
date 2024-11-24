<?php

use App\Http\Controllers\CardController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ModuleController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\RoleController;
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
        ->controller(ProductController::class)
        ->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/show/{id}', 'show')->name('show');

            Route::get('/create', 'create')->name('create');
            Route::post('store', 'store')->name('store');
            Route::post('upload-image/{id}', 'upload')->name('upload.image');

            Route::get('edit/{id}', 'edit')->name('edit');
            Route::put('update/{id}', 'update')->name('update');
            Route::put('update-status/{id}', 'updateStatus')->name('update.status');

            Route::delete('destroy', 'destroy')->name('destroy');
        });

    Route::prefix('customer')
        ->name('customer.')
        ->controller(CustomerController::class)
        ->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('show/{id}', 'show')->name('show');

            Route::get('create', 'create')->name('create');
            Route::post('store', 'store')->name('store');

            Route::get('edit/{id}', 'edit')->name('edit');
            Route::put('update/{id}', 'update')->name('update');

            Route::delete('destroy', 'destroy')->name('destroy');
        });

    Route::group([], function () {
        Route::prefix('purchase')
            ->name('purchase.')
            ->controller(PurchaseController::class)
            ->group(function () {
                Route::get('/', 'index')->name('index');
                Route::get('show/{id}', 'show')->name('show');

                Route::get('create', 'create')->name('create');
                Route::post('store', 'store')->name('store');

                Route::get('edit/{id}', 'edit')->name('edit');
                Route::put('update/{id}', 'update')->name('update');

                Route::delete('destroy', 'destroy')->name('destroy');
            });
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

    Route::prefix('profile')
        ->name('profile.')
        ->controller(ProfileController::class)
        ->group(function () {
            Route::get('profile', 'edit')->name('edit');
            Route::put('profile', 'update')->name('update');
            Route::delete('profile', 'destroy')->name('destroy');
        });

    Route::group([], function () {
        Route::prefix('staff')
            ->name('staff.')
            ->controller(StaffController::class)
            ->group(function () {
                Route::get('/', 'index')->name('index');
                Route::get('/show/{id}', 'show')->name('show');

                Route::get('/create', 'create')->name('create');
                Route::post('/store', 'store')->name('store');

                Route::get('edit/{id}', 'edit')->name('edit');
                Route::put('update/{id}', 'update')->name('update');
                Route::patch('update-role-permission/{id}', 'updateRolePermission')->name('patch.role.permission');

                Route::delete('destroy', 'destroy')->name('destroy');
            });

        Route::prefix('module')
            ->name('module.')
            ->controller(ModuleController::class)
            ->group(function () {
                Route::get('/', 'index')->name('index');
                Route::post('/save', 'store')->name('store');
                Route::put('update/{id}', 'update')->name('update');
                Route::delete('destroy', 'destroy')->name('destroy');
            });

        Route::prefix('role')
            ->name('role.')
            ->controller(RoleController::class)
            ->group(function () {
                Route::get('/', 'index')->name('index');
                Route::get('/show/{id}', 'show')->name('show');

                Route::get('/create', 'create')->name('create');
                Route::post('/save', 'store')->name('store');

                Route::get('/edit/{id}', 'edit')->name('edit');
                Route::put('update/{id}', 'update')->name('update');

                Route::patch('update-permissions/{id}', 'patchPermissions')->name('patch.permissions');

                Route::delete('destroy', 'destroy')->name('destroy');
            });

        Route::prefix('setting')
            ->name('setting.')
            ->controller(SettingController::class)
            ->group(function () {
                Route::get('/', 'show')->name('show');
                Route::put('update', 'update')->name('update');
            });
    });
});

require __DIR__.'/auth.php';
