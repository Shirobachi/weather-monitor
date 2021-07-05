<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\authController;


Route::get('/', [authController::class, 'login']);
Route::post('/', [authController::class, 'tryLogin']);

Route::get('register', [authController::class, 'register']);
Route::post('register', [authController::class, 'signup']);

Route::get('/logout', function () {
  session()->forget('userID');
  return redirect(url('/'));
});
