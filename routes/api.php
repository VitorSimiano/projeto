<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProdutoController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\PedidoController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
});

Route::get('/produtos', [ProdutoController::class, 'index']);   // listar
Route::get('/produtos/{id}', [ProdutoController::class, 'show']); // detalhe

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/produtos', [ProdutoController::class, 'store']);   // criar
    Route::put('/produtos/{id}', [ProdutoController::class, 'update']); // atualizar
    Route::delete('/produtos/{id}', [ProdutoController::class, 'destroy']); // deletar
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/clientes', [ClienteController::class, 'index']);   // listar
    Route::get('/clientes/{id}', [ClienteController::class, 'show']); // detalhe
    Route::post('/clientes', [ClienteController::class, 'store']);   // criar
    Route::put('/clientes/{id}', [ClienteController::class, 'update']); // atualizar
    Route::delete('/clientes/{id}', [ClienteController::class, 'destroy']); // deletar
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/pedidos', [PedidoController::class, 'index']);
    Route::get('/pedidos/{id}', [PedidoController::class, 'show']);
    Route::post('/pedidos', [PedidoController::class, 'store']);
    Route::put('/pedidos/{id}', [PedidoController::class, 'update']);
    Route::delete('/pedidos/{id}', [PedidoController::class, 'destroy']);
});
