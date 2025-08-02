<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MachineController;
use App\Http\Controllers\MachineCounterController;
use App\Http\Controllers\MachineCounterLogController;

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
    Route::get('stocks/minimum', [\App\Http\Controllers\StockController::class, 'minimumStock'])->name('stocks.minimum');
    Route::resource('purchasing', \App\Http\Controllers\PurchasingController::class);
    Route::resource('machines', MachineController::class);
    Route::post('machines/{id}/restore', [MachineController::class, 'restore'])->name('machines.restore');
    Route::resource('machine-counters', MachineCounterController::class)->except(['create','edit','show']);
    Route::post('machine-counters/{id}/restore', [MachineCounterController::class, 'restore'])->name('machine-counters.restore');
    Route::resource('machine-counter-logs', MachineCounterLogController::class)->only(['index','store','update','destroy']);
    Route::post('machine-counter-logs/{id}/restore',[MachineCounterLogController::class,'restore'])->name('machine-counter-logs.restore');
});
