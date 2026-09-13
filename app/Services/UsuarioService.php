<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Hash;

class UsuarioService
{
    /**
     * Listar todos los usuarios.
     */
    public function listar(): Collection
    {
        return User::orderBy('id', 'desc')->get();
    }

    /**
     * Listar usuarios paginados.
     */
    public function listarPaginados(int $perPage = 10): LengthAwarePaginator
    {
        return User::orderBy('id', 'desc')->paginate($perPage);
    }

    /**
     * Obtener los datos de un usuario por su ID.
     */
    public function obtenerPorId(int $id): ?User
    {
        return User::find($id);
    }

    /**
     * Agregar un nuevo usuario (con password cifrada).
     */
    public function crear(array $data): User
    {
        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }

        return User::create($data);
    }

    /**
     * Actualizar un usuario por su ID.
     */
    public function actualizar(User|int $user, array $data): User
    {
        if (is_int($user)) {
            $user = User::findOrFail($user);
        }

        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        $user->update($data);

        return $user->fresh();
    }

    /**
     * Eliminar un usuario por su ID.
     */
    public function eliminar(User|int $user): bool
    {
        if (is_int($user)) {
            $user = User::findOrFail($user);
        }

        return (bool) $user->delete();
    }

    /**
     * Contar usuarios para el dashboard.
     */
    public function contar(): int
    {
        return User::count();
    }
}
