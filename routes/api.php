<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\accessController;
use App\Http\Controllers\usersTownsController;
use App\Http\Controllers\townController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('towns', [townController::class, 'index']);
Route::get('weatherNow/{id}', [usersTownsController::class, 'index']);
Route::get('showMore/{id}', [usersTownsController::class, 'show']);

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});