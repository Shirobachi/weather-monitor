<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\authController;


Route::get('/', [authController::class, 'login']);
Route::get('register', [authController::class, 'register']);