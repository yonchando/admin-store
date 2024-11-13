<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

use App\Http\Controllers\ModuleController;

Route::group([
    'middleware' => ['auth'],
], function () {
    Route::get('modules', [ModuleController::class, 'index'])->name('modules.index');
});
