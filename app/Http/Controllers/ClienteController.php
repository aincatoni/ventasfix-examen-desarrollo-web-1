<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreClienteRequest;
use App\Http\Requests\UpdateClienteRequest;
use App\Services\ClienteService;
use App\Services\SoftlandService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ClienteController extends Controller
{
    public function __construct(
        protected ClienteService $clienteService,
        protected SoftlandService $softlandService
    ) {}

    /**
     * 3.1 Listar todos los clientes.
     */
    public function index(): View
    {
        $clientes = $this->clienteService->listarPaginados(10);

        return view('clientes.index', compact('clientes'));
    }

    /**
     * 3.2 Obtener los datos de un cliente por su ID (para edición/modal).
     */
    public function show(int $id): JsonResponse
    {
        $cliente = $this->clienteService->obtenerPorId($id);

        if (!$cliente) {
            return response()->json(['error' => 'Cliente no encontrado'], 404);
        }

        return response()->json($cliente);
    }

    /**
     * 3.3 Agregar un nuevo cliente.
     */
    public function store(StoreClienteRequest $request): RedirectResponse
    {
        $cliente = $this->clienteService->crear($request->validated());

        // Consumo de servicio externo para validación empresarial
        $this->softlandService->consultarEmpresa($cliente->rut_empresa);

        return redirect()->route('clientes.index')
            ->with('success', "Cliente empresa '{$cliente->razon_social}' registrado correctamente.");
    }

    /**
     * 3.4 Actualizar un cliente por su ID.
     */
    public function update(UpdateClienteRequest $request, int $id): RedirectResponse
    {
        $cliente = $this->clienteService->obtenerPorId($id);

        if (!$cliente) {
            return redirect()->route('clientes.index')
                ->with('error', 'Cliente no encontrado.');
        }

        $clienteActualizado = $this->clienteService->actualizar($cliente, $request->validated());

        return redirect()->route('clientes.index')
            ->with('success', "Cliente empresa '{$clienteActualizado->razon_social}' actualizado correctamente.");
    }

    /**
     * 3.5 Eliminar un cliente por su ID.
     */
    public function destroy(int $id): RedirectResponse
    {
        $cliente = $this->clienteService->obtenerPorId($id);

        if (!$cliente) {
            return redirect()->route('clientes.index')
                ->with('error', 'Cliente no encontrado.');
        }

        $this->clienteService->eliminar($cliente);

        return redirect()->route('clientes.index')
            ->with('success', 'Cliente eliminado correctamente.');
    }
}
