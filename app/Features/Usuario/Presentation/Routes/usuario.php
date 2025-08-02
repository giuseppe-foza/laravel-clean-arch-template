<?php

use App\Features\Usuario\Presentation\Controllers\UsuarioController;
use Illuminate\Support\Facades\Route;

Route::get('/', [UsuarioController::class, 'listarTodos']);
