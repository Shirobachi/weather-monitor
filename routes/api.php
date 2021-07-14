<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\weatherController;
use App\Http\Controllers\usersTownsController;

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

Route::get('towns', [weatherController::class, 'getTowns']);
Route::get('weatherNow/{id}', [usersTownsController::class, 'index']);
Route::get('showMore/{id}', [usersTownsController::class, 'show']);
Route::get('userTownList/{id}', [weatherController::class, 'getUserTownList']);


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});