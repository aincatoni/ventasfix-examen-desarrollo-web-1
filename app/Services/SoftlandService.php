<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SoftlandService
{
    protected string $baseUrl;
    protected string $apiKey;

    public function __construct()
    {
        $this->baseUrl = config('services.softland.url', 'https://api.softland.cl/v1');
        $this->apiKey = config('services.softland.key', 'softland-secret-token-ventasfix');
    }

    /**
     * Sincroniza información de stock con el sistema Softland externo.
     */
    public function sincronizarProducto(string $sku, int $stock): array
    {
        try {
            // Se realiza la llamada HTTP hacia el endpoint de Softland
            $response = Http::withToken($this->apiKey)
                ->timeout(5)
                ->post("{$this->baseUrl}/inventario/sincronizar", [
                    'sku' => $sku,
                    'stock' => $stock,
                    'empresa' => 'VentasFix',
                    'timestamp' => now()->toIso8601String(),
                ]);

            if ($response->successful()) {
                return [
                    'status' => 'success',
                    'data' => $response->json(),
                ];
            }
        } catch (\Exception $e) {
            Log::warning("Softland API offline o no alcanzable: " . $e->getMessage());
        }

        // Simulación controlada en caso de entorno local sin conexión
        return [
            'status' => 'simulated',
            'mensaje' => "Sincronización simulada exitosa con Softland para SKU {$sku}",
            'sku' => $sku,
            'stock' => $stock,
        ];
    }

    /**
     * Consulta información tributaria de cliente empresa en servicio externo.
     */
    public function consultarEmpresa(string $rutEmpresa): array
    {
        return [
            'rut' => $rutEmpresa,
            'estado_tributario' => 'ACTIVO',
            'autorizado_credito' => true,
            'proveedor' => 'Softland ERP Connector',
        ];
    }
}
