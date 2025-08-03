<?php

use App\Features\Usuario\Presentation\Controllers\UsuarioController;
use Illuminate\Support\Facades\Route;

Route::get('/', [UsuarioController::class, 'listarTodos']);
Route::get('/{id}', [UsuarioController::class, 'listarPorId']);
Route::post('/', [UsuarioController::class, 'inserir']);
Route::put('/{id}', [UsuarioController::class, 'editar']);
