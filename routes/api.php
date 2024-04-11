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


//! Route::middleware('authentication')->group(function () {

// });

/* USUARIOS */
Route::post('user/create', [\App\Http\Controllers\UserController::class, 'createUser']);
Route::get('user/search/{where}', [\App\Http\Controllers\UserController::class, 'getUser']);
Route::get('user/list-users', [\App\Http\Controllers\UserController::class, 'listUsers']);
Route::delete('user/delete/{id}', [\App\Http\Controllers\UserController::class, 'deleteUser']);
Route::get('user/archive/{id}', [\App\Http\Controllers\UserController::class, 'archiveUser']);

/*ALMACENES */
Route::post('store/create', [\App\Http\Controllers\SucursalesController::class, 'createDynamicStore']);
Route::post('store/assign-users', [\App\Http\Controllers\SucursalesController::class, 'assignUserToStore']);
/*ROLES DE USUARIOS */
Route::get('status/list-roles', [\App\Http\Controllers\StatusController::class, 'listRoles']);
