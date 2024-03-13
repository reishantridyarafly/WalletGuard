<?php

use Illuminate\Support\Facades\Auth;
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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();
Route::middleware(['auth', 'user-access:Administrator'])->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard.index');

    Route::get('/category', [App\Http\Controllers\CategoryController::class, 'index'])->name('category.index');
    Route::post('/category', [App\Http\Controllers\CategoryController::class, 'store'])->name('category.store');
    Route::get('/category/{id}/edit', [App\Http\Controllers\CategoryController::class, 'edit'])->name('category.edit');
    Route::delete('/category/{id}', [App\Http\Controllers\CategoryController::class, 'destroy'])->name('category.destroy');

    Route::get('/income', [App\Http\Controllers\IncomeController::class, 'index'])->name('income.index');
    Route::get('/income/total', [App\Http\Controllers\IncomeController::class, 'total'])->name('income.total');
    Route::post('/income', [App\Http\Controllers\IncomeController::class, 'store'])->name('income.store');
    Route::get('/income/{id}/edit', [App\Http\Controllers\IncomeController::class, 'edit'])->name('income.edit');
    Route::delete('/income/{id}', [App\Http\Controllers\IncomeController::class, 'destroy'])->name('income.destroy');

});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
