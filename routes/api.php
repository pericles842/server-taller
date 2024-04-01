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

Route::post('user/authentication', [\App\Http\Controllers\UserController::class, 'authenticateUser']);
Route::post('user/logout', [\App\Http\Controllers\UserController::class, 'logoutUser']);



Route::middleware('authentication')->group(function () {
    Route::post('user/create', [\App\Http\Controllers\UserController::class, 'createUser']);
    Route::get('user/search/{where}', [\App\Http\Controllers\UserController::class, 'getUser']);
});
