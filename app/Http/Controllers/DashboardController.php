<?php

namespace App\Http\Controllers;

use App\Services\ClienteService;
use App\Services\ProductoService;
use App\Services\UsuarioService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __construct(
        protected UsuarioService $usuarioService,
        protected ProductoService $productoService,
        protected ClienteService $clienteService
    ) {}

    /**
     * Muestra la pantalla principal del Dashboard con las métricas solicitadas.
     * 4.1 Información de cuántos usuarios tiene el sistema.
     * 4.2 Información de cuántos productos tiene el sistema.
     * 4.3 Información de cuántos clientes tiene el sistema.
     */
    public function index(): View
    {
        $totalUsuarios = $this->usuarioService->contar();
        $totalProductos = $this->productoService->contar();
        $totalClientes = $this->clienteService->contar();

        $usuariosRecientes = $this->usuarioService->listar()->take(5);
        $productosRecientes = $this->productoService->listar()->take(5);
        $clientesRecientes = $this->clienteService->listar()->take(5);

        return view('dashboard', compact(
            'totalUsuarios',
            'totalProductos',
            'totalClientes',
            'usuariosRecientes',
            'productosRecientes',
            'clientesRecientes'
        ));
    }
}
