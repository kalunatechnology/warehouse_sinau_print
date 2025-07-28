<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::middleware('auth')->group(function () {
    Route::resource('warehouses', \App\Http\Controllers\WarehouseController::class);
    Route::resource('units', \App\Http\Controllers\UnitController::class);
    Route::resource('materials', \App\Http\Controllers\MaterialController::class);
    Route::get('stocks', [\App\Http\Controllers\StockController::class, 'index'])->name('stocks.index');
});
