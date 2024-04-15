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

/* USUARIOS CRUD */
Route::post('user/create', [\App\Http\Controllers\UserController::class, 'createUser']);
Route::get('user/search/{where}', [\App\Http\Controllers\UserController::class, 'getUser']);
Route::get('user/list-users', [\App\Http\Controllers\UserController::class, 'listUsers']);
Route::delete('user/delete/{id}', [\App\Http\Controllers\UserController::class, 'deleteUser']);
Route::get('user/archive/{id}', [\App\Http\Controllers\UserController::class, 'archiveUser']);

/*ALMACENES CRUD */
Route::post('store/create', [\App\Http\Controllers\SucursalesController::class, 'createDynamicStore']);
Route::post('store/assign-users', [\App\Http\Controllers\SucursalesController::class, 'assignUserToStore']);
Route::get('store/list-store', [\App\Http\Controllers\SucursalesController::class, 'listStore']);
Route::delete('store/delete/{id}', [\App\Http\Controllers\SucursalesController::class, 'deleteStore']);
Route::get('store/archive/{id}', [\App\Http\Controllers\SucursalesController::class, 'closeStore']);

/* TIENDAS CRUD */
Route::post('shop/create', [\App\Http\Controllers\SucursalesController::class, 'createDynamicShop']);
Route::post('shop/assign-users', [\App\Http\Controllers\SucursalesController::class, 'assignUserToShop']);
Route::get('shop/list-shop', [\App\Http\Controllers\SucursalesController::class, 'listShops']);
Route::delete('shop/delete/{id}', [\App\Http\Controllers\SucursalesController::class, 'deleteShop']);
Route::get('shop/archive/{id}', [\App\Http\Controllers\SucursalesController::class, 'closeShop']);

Route::get('branch/list-uses', [\App\Http\Controllers\SucursalesController::class, 'listUserNotBranch']);
 


/*ROLES DE USUARIOS */
Route::get('status/list-roles', [\App\Http\Controllers\StatusController::class, 'listRoles']);
