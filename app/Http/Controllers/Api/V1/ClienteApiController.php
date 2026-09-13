<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreClienteRequest;
use App\Http\Requests\UpdateClienteRequest;
use App\Http\Resources\ClienteResource;
use App\Services\ClienteService;
use App\Services\SoftlandService;
use Illuminate\Http\JsonResponse;

class ClienteApiController extends Controller
{
    public function __construct(
        protected ClienteService $clienteService,
        protected SoftlandService $softlandService
    ) {}

    /**
     * 3.1 Listar todos los clientes.
     */
    public function index(): JsonResponse
    {
        $clientes = $this->clienteService->listar();

        return response()->json([
            'codigo' => 200,
            'mensaje' => 'Lista de clientes recuperada exitosamente',
            'datos' => ClienteResource::collection($clientes),
        ], 200);
    }

    /**
     * 3.2 Obtener los datos de un cliente por su ID.
     */
    public function show(int $id): JsonResponse
    {
        $cliente = $this->clienteService->obtenerPorId($id);

        if (!$cliente) {
            return response()->json([
                'codigo' => 404,
                'mensaje' => "El cliente con ID {$id} no fue encontrado.",
            ], 404);
        }

        return response()->json([
            'codigo' => 200,
            'mensaje' => 'Cliente recuperado exitosamente',
            'datos' => new ClienteResource($cliente),
        ], 200);
    }

    /**
     * 3.3 Agregar un nuevo cliente.
     */
    public function store(StoreClienteRequest $request): JsonResponse
    {
        $cliente = $this->clienteService->crear($request->validated());

        // Verificación o registro con Softland
        $infoTributaria = $this->softlandService->consultarEmpresa($cliente->rut_empresa);

        return response()->json([
            'codigo' => 201,
            'mensaje' => 'Cliente registrado exitosamente',
            'datos' => new ClienteResource($cliente),
            'validacion_externa' => $infoTributaria,
        ], 201);
    }

    /**
     * 3.4 Actualizar un cliente por su ID.
     */
    public function update(UpdateClienteRequest $request, int $id): JsonResponse
    {
        $cliente = $this->clienteService->obtenerPorId($id);

        if (!$cliente) {
            return response()->json([
                'codigo' => 404,
                'mensaje' => "El cliente con ID {$id} no fue encontrado.",
            ], 404);
        }

        $clienteActualizado = $this->clienteService->actualizar($cliente, $request->validated());

        return response()->json([
            'codigo' => 200,
            'mensaje' => 'Cliente actualizado exitosamente',
            'datos' => new ClienteResource($clienteActualizado),
        ], 200);
    }

    /**
     * 3.5 Eliminar un cliente por su ID.
     */
    public function destroy(int $id): JsonResponse
    {
        $cliente = $this->clienteService->obtenerPorId($id);

        if (!$cliente) {
            return response()->json([
                'codigo' => 404,
                'mensaje' => "El cliente con ID {$id} no fue encontrado.",
            ], 404);
        }

        $this->clienteService->eliminar($cliente);

        return response()->json([
            'codigo' => 200,
            'mensaje' => 'Cliente eliminado exitosamente',
        ], 200);
    }
}
