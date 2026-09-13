<?php

use App\Http\Controllers\ClienteController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\UsuarioController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes - VentasFix Backoffice
|--------------------------------------------------------------------------
*/

// Rutas de autenticación de Laravel Breeze
require __DIR__ . '/auth.php';

// Rutas del Backoffice protegidas por sesión (auth)
Route::middleware('auth')->group(function () {
    // Dashboard principal
    Route::get('/', [DashboardController::class, 'index'])->name('root');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // 1. Mantenedor de Usuarios
    Route::resource('usuarios', UsuarioController::class);

    // 2. Mantenedor de Productos
    Route::resource('productos', ProductoController::class);

    // 3. Mantenedor de Clientes
    Route::resource('clientes', ClienteController::class);
});
