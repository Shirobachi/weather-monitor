<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\authController;
use App\Http\Controllers\accessController;
use App\Http\Controllers\usersTownsController;

Route::get('/', [accessController::class, 'login']);
Route::post('/', [authController::class, 'tryLogin']);

Route::get('register', [accessController::class, 'register']);
Route::post('register', [authController::class, 'create']);

Route::get('/logout', function () {
  session()->forget('userID');
  return redirect(url('/'));
});
Route::get('dashboard', [accessController::class, 'dashboard']);
Route::post('addTown', [usersTownsController::class, 'store']);

Route::get('showMore/{id}', [accessController::class, 'showMore']);

Route::get('remove/{id}', [usersTownsController::class, 'destroy']);