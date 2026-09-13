<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUsuarioRequest;
use App\Http\Requests\UpdateUsuarioRequest;
use App\Services\UsuarioService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UsuarioController extends Controller
{
    public function __construct(
        protected UsuarioService $usuarioService
    ) {}

    /**
     * 1.1 Listar todos los usuarios.
     */
    public function index(): View
    {
        $usuarios = $this->usuarioService->listarPaginados(10);

        return view('usuarios.index', compact('usuarios'));
    }

    /**
     * 1.2 Obtener los datos de un usuario por su ID (para edición/modal).
     */
    public function show(int $id): JsonResponse
    {
        $usuario = $this->usuarioService->obtenerPorId($id);

        if (!$usuario) {
            return response()->json(['error' => 'Usuario no encontrado'], 404);
        }

        return response()->json($usuario);
    }

    /**
     * 1.3 Agregar un nuevo usuario.
     */
    public function store(StoreUsuarioRequest $request): RedirectResponse
    {
        $this->usuarioService->crear($request->validated());

        return redirect()->route('usuarios.index')
            ->with('success', 'Usuario registrado correctamente.');
    }

    /**
     * 1.4 Actualizar un usuario por su ID.
     */
    public function update(UpdateUsuarioRequest $request, int $id): RedirectResponse
    {
        $usuario = $this->usuarioService->obtenerPorId($id);

        if (!$usuario) {
            return redirect()->route('usuarios.index')
                ->with('error', 'Usuario no encontrado.');
        }

        $this->usuarioService->actualizar($usuario, $request->validated());

        return redirect()->route('usuarios.index')
            ->with('success', 'Usuario actualizado correctamente.');
    }

    /**
     * 1.5 Eliminar un usuario por su ID.
     */
    public function destroy(int $id): RedirectResponse
    {
        $usuario = $this->usuarioService->obtenerPorId($id);

        if (!$usuario) {
            return redirect()->route('usuarios.index')
                ->with('error', 'Usuario no encontrado.');
        }

        $this->usuarioService->eliminar($usuario);

        return redirect()->route('usuarios.index')
            ->with('success', 'Usuario eliminado correctamente.');
    }
}
