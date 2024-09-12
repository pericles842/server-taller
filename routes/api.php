<?php

namespace App\Models;

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

/**Autenteicacion */
// Route::get('auth', function () {
//     $a = new Charges();
//     return $a->getChargeJob();
// });

/* PERMISOS ROLES CARGOS */
Route::get('access/user', [\App\Http\Controllers\ChargesController::class, 'getPermissionUser']);

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
Route::get('shop/list-shop', [\App\Http\Controllers\SucursalesController::class, 'listShops']);
Route::delete('shop/delete/{id}', [\App\Http\Controllers\SucursalesController::class, 'deleteShop']);
Route::get('shop/archive/{id}', [\App\Http\Controllers\SucursalesController::class, 'closeShop']);

/* sucursales CRUD */
Route::get('branch/users-not-branch', [\App\Http\Controllers\SucursalesController::class, 'listUserNotBranch']);
Route::get('branch/all-branch', [\App\Http\Controllers\SucursalesController::class, 'getBranchAll']);
Route::post('branch/users', [\App\Http\Controllers\SucursalesController::class, 'getUsersBranch']);
Route::post('branch/assign-users', [\App\Http\Controllers\SucursalesController::class, 'assignUserToBranch']);

/*ROLES DE USUARIOS */
Route::get('status/list-roles', [\App\Http\Controllers\StatusController::class, 'listRoles']);

/*MONEDAS Y TASAS */
Route::post('coin', [\App\Http\Controllers\CoinsController::class, 'crudCoins']);
Route::delete('coin/{id}', [\App\Http\Controllers\CoinsController::class, 'deleteCoin']);
Route::get('coin', [\App\Http\Controllers\CoinsController::class, 'getCoins']);
Route::post('coin/price', [\App\Http\Controllers\CoinsController::class, 'savePriceToACurrency']);
Route::put('coin/price', [\App\Http\Controllers\CoinsController::class, 'updatePriceToACurrency']);
Route::delete('coin/price/{id}', [\App\Http\Controllers\CoinsController::class, 'deletePriceToCurrency']);

/*PRODUCTOS, CATEGORIAS */
Route::post('product/attributes', [\App\Http\Controllers\ProductsController::class, 'createProductsAttributes']);
Route::post('product', [\App\Http\Controllers\ProductsController::class, 'dynamicCreateProduct']);
Route::delete('product/{id}', [\App\Http\Controllers\ProductsController::class, 'deleteProduct']);
Route::post('category', [\App\Http\Controllers\ProductsController::class, 'createCategory']);
Route::delete('category/{id}', [\App\Http\Controllers\ProductsController::class, 'deleteCategory']);
Route::get('category', [\App\Http\Controllers\ProductsController::class, 'getCategories']);
Route::get('category/tree', [\App\Http\Controllers\ProductsController::class, 'getTreeCategories']);

/*LISTA DE PRECIOS */
Route::post('price-list', [\App\Http\Controllers\PriceListController::class, 'createPriceList']);
Route::delete('price-list/{id}', [\App\Http\Controllers\PriceListController::class, 'deletePriceList']);
Route::get('price-list', [\App\Http\Controllers\PriceListController::class, 'getPriceList']);
