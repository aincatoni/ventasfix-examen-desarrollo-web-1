<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUsuarioRequest;
use App\Http\Requests\UpdateUsuarioRequest;
use App\Http\Resources\UsuarioResource;
use App\Services\UsuarioService;
use Illuminate\Http\JsonResponse;

class UsuarioApiController extends Controller
{
    public function __construct(
        protected UsuarioService $usuarioService
    ) {}

    /**
     * 1.1 Listar todos los usuarios.
     */
    public function index(): JsonResponse
    {
        $usuarios = $this->usuarioService->listar();

        return response()->json([
            'codigo' => 200,
            'mensaje' => 'Lista de usuarios recuperada exitosamente',
            'datos' => UsuarioResource::collection($usuarios),
        ], 200);
    }

    /**
     * 1.2 Obtener los datos de un usuario por su ID.
     */
    public function show(int $id): JsonResponse
    {
        $usuario = $this->usuarioService->obtenerPorId($id);

        if (!$usuario) {
            return response()->json([
                'codigo' => 404,
                'mensaje' => "El usuario con ID {$id} no fue encontrado.",
            ], 404);
        }

        return response()->json([
            'codigo' => 200,
            'mensaje' => 'Usuario recuperado exitosamente',
            'datos' => new UsuarioResource($usuario),
        ], 200);
    }

    /**
     * 1.3 Agregar un nuevo usuario.
     */
    public function store(StoreUsuarioRequest $request): JsonResponse
    {
        $usuario = $this->usuarioService->crear($request->validated());

        return response()->json([
            'codigo' => 201,
            'mensaje' => 'Usuario creado exitosamente',
            'datos' => new UsuarioResource($usuario),
        ], 201);
    }

    /**
     * 1.4 Actualizar un usuario por su ID.
     */
    public function update(UpdateUsuarioRequest $request, int $id): JsonResponse
    {
        $usuario = $this->usuarioService->obtenerPorId($id);

        if (!$usuario) {
            return response()->json([
                'codigo' => 404,
                'mensaje' => "El usuario con ID {$id} no fue encontrado.",
            ], 404);
        }

        $usuarioActualizado = $this->usuarioService->actualizar($usuario, $request->validated());

        return response()->json([
            'codigo' => 200,
            'mensaje' => 'Usuario actualizado exitosamente',
            'datos' => new UsuarioResource($usuarioActualizado),
        ], 200);
    }

    /**
     * 1.5 Eliminar un usuario por su ID.
     */
    public function destroy(int $id): JsonResponse
    {
        $usuario = $this->usuarioService->obtenerPorId($id);

        if (!$usuario) {
            return response()->json([
                'codigo' => 404,
                'mensaje' => "El usuario con ID {$id} no fue encontrado.",
            ], 404);
        }

        $this->usuarioService->eliminar($usuario);

        return response()->json([
            'codigo' => 200,
            'mensaje' => 'Usuario eliminado exitosamente',
        ], 200);
    }
}
