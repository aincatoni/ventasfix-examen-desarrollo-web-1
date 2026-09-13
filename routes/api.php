<?php

use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\ClienteApiController;
use App\Http\Controllers\Api\V1\ProductoApiController;
use App\Http\Controllers\Api\V1\UsuarioApiController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes - VentasFix
|--------------------------------------------------------------------------
| Rutas protegidas y versionadas para la integración de terceros (Softland).
| Cumple con el método de autenticación Bearer Token (Sanctum).
*/

Route::prefix('v1')->group(function () {
    // Autenticación de API
    Route::post('/auth/login', [AuthController::class, 'login']);

    // Rutas protegidas por Sanctum
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/auth/logout', [AuthController::class, 'logout']);

        // 1. Usuarios API
        Route::apiResource('usuarios', UsuarioApiController::class);

        // 2. Productos API
        Route::apiResource('productos', ProductoApiController::class);

        // 3. Clientes API
        Route::apiResource('clientes', ClienteApiController::class);
    });
});
