<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
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

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
