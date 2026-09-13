<?php

namespace App\Services;

use App\Models\Cliente;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class ClienteService
{
    /**
     * Listar todos los clientes.
     */
    public function listar(): Collection
    {
        return Cliente::orderBy('id', 'desc')->get();
    }

    /**
     * Listar clientes paginados.
     */
    public function listarPaginados(int $perPage = 10): LengthAwarePaginator
    {
        return Cliente::orderBy('id', 'desc')->paginate($perPage);
    }

    /**
     * Obtener un cliente por su ID.
     */
    public function obtenerPorId(int $id): ?Cliente
    {
        return Cliente::find($id);
    }

    /**
     * Agregar un nuevo cliente empresa.
     */
    public function crear(array $data): Cliente
    {
        return Cliente::create($data);
    }

    /**
     * Actualizar un cliente por su ID.
     */
    public function actualizar(Cliente|int $cliente, array $data): Cliente
    {
        if (is_int($cliente)) {
            $cliente = Cliente::findOrFail($cliente);
        }

        $cliente->update($data);

        return $cliente->fresh();
    }

    /**
     * Eliminar un cliente por su ID.
     */
    public function eliminar(Cliente|int $cliente): bool
    {
        if (is_int($cliente)) {
            $cliente = Cliente::findOrFail($cliente);
        }

        return (bool) $cliente->delete();
    }

    /**
     * Contar clientes para el dashboard.
     */
    public function contar(): int
    {
        return Cliente::count();
    }
}
