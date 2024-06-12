<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Auth::routes();
Auth::routes(['verify' => true]);

Route::get('/', [App\Http\Controllers\HomeController::class, 'welcome'])->name('welcome');
Route::middleware('auth','verified')->get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::middleware('auth','verified')->get('/profile', [App\Http\Controllers\HomeController::class, 'profile'])->name('profile');
Route::middleware('auth','verified')->put('/profile/update', [App\Http\Controllers\HomeController::class, 'update_profile'])->name('profile.update');
Route::middleware('auth','verified')->post('/make', [App\Http\Controllers\HomeController::class, 'make'])->name('make');
Route::middleware('auth','verified')->put('/update/{id}', [App\Http\Controllers\HomeController::class, 'update'])->name('update');
Route::middleware('auth','verified')->delete('/delete/{id}', [App\Http\Controllers\HomeController::class, 'delete'])->name('delete');



