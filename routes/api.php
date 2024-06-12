<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'finance'], function(){
    Route::post('/login', [App\Http\Controllers\FinanceController::class, 'login'])->name('finance.login');
    Route::middleware('auth:sanctum')->post('/logout', [App\Http\Controllers\FinanceController::class, 'logout'])->name('finance.logout');
    Route::middleware('auth:sanctum')->get('/profile', [App\Http\Controllers\FinanceController::class, 'getProfile'])->name('finance.profile');
    Route::middleware('auth:sanctum')->post('/update/profile', [App\Http\Controllers\FinanceController::class, 'updateProfile'])->name('finance.profile');
    Route::middleware('auth:sanctum')->post('/add', [App\Http\Controllers\FinanceController::class, 'addFinance'])->name('finance.add');
    Route::middleware('auth:sanctum')->post('/update/{id}', [App\Http\Controllers\FinanceController::class, 'updateFinance'])->name('finance.update');
    Route::middleware('auth:sanctum')->get('/users', [App\Http\Controllers\FinanceController::class, 'listUser'])->name('finance.users');
});

Route::group(['prefix' => 'inventory'], function(){
    Route::post('/login', [App\Http\Controllers\InventarisController::class, 'login'])->name('inventaris.login');
    Route::middleware('auth:sanctum')->post('/logout', [App\Http\Controllers\InventarisController::class, 'logout'])->name('inventaris.logout');
    Route::middleware('auth:sanctum')->get('/profile', [App\Http\Controllers\InventarisController::class, 'getProfile'])->name('inventaris.profile');
    Route::middleware('auth:sanctum')->post('/update/profile', [App\Http\Controllers\InventarisController::class, 'updateProfile'])->name('inventaris.profile');
    Route::middleware('auth:sanctum')->post('/add', [App\Http\Controllers\InventarisController::class, 'addInventaris'])->name('inventaris.add');
    Route::middleware('auth:sanctum')->post('/update/{id}', [App\Http\Controllers\InventarisController::class, 'updateInventaris'])->name('inventaris.update');
    Route::middleware('auth:sanctum')->post('/delete/{id}', [App\Http\Controllers\InventarisController::class, 'deleteInventaris'])->name('inventaris.delete');
    Route::middleware('auth:sanctum')->get('/', [App\Http\Controllers\InventarisController::class, 'listInventaris'])->name('inventaris.delete');
    Route::middleware('auth:sanctum')->get('/{id}', [App\Http\Controllers\InventarisController::class, 'inventarisById'])->name('inventaris.ByID');
});