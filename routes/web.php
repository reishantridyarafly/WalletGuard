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

Route::get('/', [App\Http\Controllers\Auth\LoginController::class, 'showLoginForm']);

Auth::routes();
Route::middleware(['auth', 'user-access:Administrator,User'])->group(function () {
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

    Route::get('/spending', [App\Http\Controllers\SpendingController::class, 'index'])->name('spending.index');
    Route::get('/spending/total', [App\Http\Controllers\SpendingController::class, 'total'])->name('spending.total');
    Route::post('/spending', [App\Http\Controllers\SpendingController::class, 'store'])->name('spending.store');
    Route::get('/spending/{id}/edit', [App\Http\Controllers\SpendingController::class, 'edit'])->name('spending.edit');
    Route::delete('/spending/{id}', [App\Http\Controllers\SpendingController::class, 'destroy'])->name('spending.destroy');

    Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'index'])->name('profile.index');
    Route::post('/profile/settings/', [App\Http\Controllers\ProfileController::class, 'settingsProfile'])->name('profile.settings');
    Route::post('/profile/settings/delete-photo', [App\Http\Controllers\ProfileController::class, 'deletePhoto'])->name('profile.deletePhoto');
    Route::post('/profile/change/password', [App\Http\Controllers\ProfileController::class, 'changePassword'])->name('profile.changePassword');
    Route::post('/profile/delete/account', [App\Http\Controllers\ProfileController::class, 'deleteAccount'])->name('profile.deleteAccount');
});

Route::middleware(['auth', 'user-access:Administrator'])->group(function () {
    Route::get('/users', [App\Http\Controllers\UsersController::class, 'index'])->name('users.index');
    Route::post('/users', [App\Http\Controllers\UsersController::class, 'store'])->name('users.store');
    Route::post('/users/updateActiveStatus', [App\Http\Controllers\UsersController::class, 'updateActiveStatus'])->name('users.updateActiveStatus');
    Route::get('/users/{id}/edit', [App\Http\Controllers\UsersController::class, 'edit'])->name('users.edit');
    Route::delete('/users/{id}', [App\Http\Controllers\UsersController::class, 'destroy'])->name('users.destroy');
});


