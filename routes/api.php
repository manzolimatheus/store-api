<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\OrderController;
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

// Usuário
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/user', [AuthController::class, 'profile'])->middleware('auth:sanctum');
Route::delete('/user', [AuthController::class, 'delete'])->middleware('auth:sanctum');
Route::get('/users/qtd', [AuthController::class, 'getCount']);

// Rotas do CRUD
Route::get('{key}/products/',[ProductController::class, 'get']);
Route::get('{key}/products/tag/{id_tag}',[ProductController::class, 'getTag']);
Route::post('{key}/products', [ProductController::class, 'create'])->middleware('auth:sanctum');
Route::put('{key}/product/{id}', [ProductController::class, 'update'])->middleware('auth:sanctum');
Route::delete('{key}/product/{id}', [ProductController::class, 'delete'])->middleware('auth:sanctum');

//Categorias
Route::get('{key}/tags', [TagController::class, 'get']);

// Pedidos
Route::post('{key}/myorders/',[OrderController::class, 'get'])->middleware('auth:sanctum');
Route::post('{key}/orders/', [OrderController::class, 'create'])->middleware('auth:sanctum');
Route::delete('{key}/order/{id}', [OrderController::class, 'delete'])->middleware('auth:sanctum');

// Admin
Route::get('{key}/admin/', [AdminController::class, 'get']);
