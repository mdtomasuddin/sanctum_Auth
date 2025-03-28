<?php

use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/register', [UserController::class, 'registration'])->name('user.register');
Route::post('/login', [UserController::class, 'login'])->name('user.login');
Route::post('/logout', [UserController::class, 'logout'])->middleware('auth:sanctum')->name('user.logout');
Route::post('/profile', [UserController::class, 'profile'])->middleware('auth:sanctum')->name('user.profile');

