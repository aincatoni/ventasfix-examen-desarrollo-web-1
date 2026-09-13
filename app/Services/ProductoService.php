<?php

namespace App\Services;

use App\Models\Producto;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class ProductoService
{
    /**
     * Listar todos los productos.
     */
    public function listar(): Collection
    {
        return Producto::orderBy('id', 'desc')->get();
    }

    /**
     * Listar productos paginados.
     */
    public function listarPaginados(int $perPage = 10): LengthAwarePaginator
    {
        return Producto::orderBy('id', 'desc')->paginate($perPage);
    }

    /**
     * Obtener un producto por su ID.
     */
    public function obtenerPorId(int $id): ?Producto
    {
        return Producto::find($id);
    }

    /**
     * Agregar un nuevo producto (calcula IVA 19% si no se proporciona).
     */
    public function crear(array $data): Producto
    {
        if (isset($data['precio_neto']) && (!isset($data['precio_venta']) || empty($data['precio_venta']))) {
            $data['precio_venta'] = Producto::calcularPrecioVenta((float) $data['precio_neto']);
        }

        return Producto::create($data);
    }

    /**
     * Actualizar un producto por su ID.
     */
    public function actualizar(Producto|int $producto, array $data): Producto
    {
        if (is_int($producto)) {
            $producto = Producto::findOrFail($producto);
        }

        if (isset($data['precio_neto']) && !isset($data['precio_venta'])) {
            $data['precio_venta'] = Producto::calcularPrecioVenta((float) $data['precio_neto']);
        }

        $producto->update($data);

        return $producto->fresh();
    }

    /**
     * Eliminar un producto por su ID.
     */
    public function eliminar(Producto|int $producto): bool
    {
        if (is_int($producto)) {
            $producto = Producto::findOrFail($producto);
        }

        return (bool) $producto->delete();
    }

    /**
     * Contar productos para el dashboard.
     */
    public function contar(): int
    {
        return Producto::count();
    }
}
