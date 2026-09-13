<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductoRequest;
use App\Http\Requests\UpdateProductoRequest;
use App\Http\Resources\ProductoResource;
use App\Services\ProductoService;
use App\Services\SoftlandService;
use Illuminate\Http\JsonResponse;

class ProductoApiController extends Controller
{
    public function __construct(
        protected ProductoService $productoService,
        protected SoftlandService $softlandService
    ) {}

    /**
     * 2.1 Listar todos los productos.
     */
    public function index(): JsonResponse
    {
        $productos = $this->productoService->listar();

        return response()->json([
            'codigo' => 200,
            'mensaje' => 'Lista de productos recuperada exitosamente',
            'datos' => ProductoResource::collection($productos),
        ], 200);
    }

    /**
     * 2.2 Obtener los datos de un producto por su ID.
     */
    public function show(int $id): JsonResponse
    {
        $producto = $this->productoService->obtenerPorId($id);

        if (!$producto) {
            return response()->json([
                'codigo' => 404,
                'mensaje' => "El producto con ID {$id} no fue encontrado.",
            ], 404);
        }

        return response()->json([
            'codigo' => 200,
            'mensaje' => 'Producto recuperado exitosamente',
            'datos' => new ProductoResource($producto),
        ], 200);
    }

    /**
     * 2.3 Agregar un nuevo producto.
     */
    public function store(StoreProductoRequest $request): JsonResponse
    {
        $producto = $this->productoService->crear($request->validated());

        // Consumo de servicio externo para sincronización de stock con Softland
        $softlandSync = $this->softlandService->sincronizarProducto($producto->sku, $producto->stock_actual);

        return response()->json([
            'codigo' => 201,
            'mensaje' => 'Producto registrado exitosamente',
            'datos' => new ProductoResource($producto),
            'sincronizacion_externa' => $softlandSync,
        ], 201);
    }

    /**
     * 2.4 Actualizar un producto por su ID.
     */
    public function update(UpdateProductoRequest $request, int $id): JsonResponse
    {
        $producto = $this->productoService->obtenerPorId($id);

        if (!$producto) {
            return response()->json([
                'codigo' => 404,
                'mensaje' => "El producto con ID {$id} no fue encontrado.",
            ], 404);
        }

        $productoActualizado = $this->productoService->actualizar($producto, $request->validated());

        // Consumo de servicio externo para mantener stock actualizado en Softland
        $softlandSync = $this->softlandService->sincronizarProducto($productoActualizado->sku, $productoActualizado->stock_actual);

        return response()->json([
            'codigo' => 200,
            'mensaje' => 'Producto actualizado exitosamente',
            'datos' => new ProductoResource($productoActualizado),
            'sincronizacion_externa' => $softlandSync,
        ], 200);
    }

    /**
     * 2.5 Eliminar un producto por su ID.
     */
    public function destroy(int $id): JsonResponse
    {
        $producto = $this->productoService->obtenerPorId($id);

        if (!$producto) {
            return response()->json([
                'codigo' => 404,
                'mensaje' => "El producto con ID {$id} no fue encontrado.",
            ], 404);
        }

        $this->productoService->eliminar($producto);

        return response()->json([
            'codigo' => 200,
            'mensaje' => 'Producto eliminado exitosamente',
        ], 200);
    }
}
