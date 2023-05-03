<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::group(['prefix' => '/auth'], function () {
    Route::post('/signup', [\App\Http\Controllers\AuthController::class, 'signup']);
    Route::post('/login', [\App\Http\Controllers\AuthController::class, 'login']);
});


Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/user', [\App\Http\Controllers\AuthController::class, 'whoami']);
    Route::get('/countries', [\App\Http\Controllers\CountryController::class, 'getAll']);
    Route::get('/countries/statistics', [\App\Http\Controllers\CountryController::class, 'getStatistics']);

});
