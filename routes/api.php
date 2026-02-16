<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProductoController;
use App\Http\Controllers\Api\CategoriaController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\WishlistController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource('/productos', ProductoController::class, ['as' => 'api']);

// Ruta adicional para todas las categorias con productos
Route::get('/categoria/productos', [CategoriaController::class, 'indexProductos']) ->name('api.categoria.productos');
// Rutas de categoria
Route::apiResource('/categoria', CategoriaController::class, ['as' => 'api']);

// Rutas de user
Route::apiResource('/usuarios', UserController::class, ['as' => 'api']);

// Rutas de wishlist
Route::apiResource('/deseos', WishlistController::class, ['as' => 'api'])->only(['index', 'show', 'store', 'destroy']);