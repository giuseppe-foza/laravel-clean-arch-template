<?php

use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\Response;

Route::get('/', function () {
    return response()->json(
        ['Message' => 'Welcome to the API.'],
        Response::HTTP_OK
    );
});

Route::get('/health', function () {
    return 'OK';
});

Route::prefix('/usuarios')->group(app_path('Features/Usuario/Presentation/Routes/usuario.php'));

