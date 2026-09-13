<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductoRequest;
use App\Http\Requests\UpdateProductoRequest;
use App\Services\ProductoService;
use App\Services\SoftlandService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ProductoController extends Controller
{
    public function __construct(
        protected ProductoService $productoService,
        protected SoftlandService $softlandService
    ) {}

    /**
     * 2.1 Listar todos los productos.
     */
    public function index(): View
    {
        $productos = $this->productoService->listarPaginados(10);

        return view('productos.index', compact('productos'));
    }

    /**
     * 2.2 Obtener los datos de un producto por su ID (para edición/modal).
     */
    public function show(int $id): JsonResponse
    {
        $producto = $this->productoService->obtenerPorId($id);

        if (!$producto) {
            return response()->json(['error' => 'Producto no encontrado'], 404);
        }

        return response()->json($producto);
    }

    /**
     * 2.3 Agregar un nuevo producto.
     */
    public function store(StoreProductoRequest $request): RedirectResponse
    {
        $producto = $this->productoService->crear($request->validated());

        // Consumo de servicio externo para notificar al sistema Softland
        $this->softlandService->sincronizarProducto($producto->sku, $producto->stock_actual);

        return redirect()->route('productos.index')
            ->with('success', "Producto {$producto->nombre} registrado correctamente con IVA incluido ($" . number_format($producto->precio_venta, 0, ',', '.') . ").");
    }

    /**
     * 2.4 Actualizar un producto por su ID.
     */
    public function update(UpdateProductoRequest $request, int $id): RedirectResponse
    {
        $producto = $this->productoService->obtenerPorId($id);

        if (!$producto) {
            return redirect()->route('productos.index')
                ->with('error', 'Producto no encontrado.');
        }

        $productoActualizado = $this->productoService->actualizar($producto, $request->validated());

        // Consumo de servicio externo para sincronización
        $this->softlandService->sincronizarProducto($productoActualizado->sku, $productoActualizado->stock_actual);

        return redirect()->route('productos.index')
            ->with('success', "Producto {$productoActualizado->nombre} actualizado correctamente.");
    }

    /**
     * 2.5 Eliminar un producto por su ID.
     */
    public function destroy(int $id): RedirectResponse
    {
        $producto = $this->productoService->obtenerPorId($id);

        if (!$producto) {
            return redirect()->route('productos.index')
                ->with('error', 'Producto no encontrado.');
        }

        $this->productoService->eliminar($producto);

        return redirect()->route('productos.index')
            ->with('success', 'Producto eliminado correctamente.');
    }
}
