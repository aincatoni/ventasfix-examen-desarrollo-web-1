<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;

    protected $table = 'productos';

    protected $fillable = [
        'sku',
        'nombre',
        'descripcion_corta',
        'descripcion_larga',
        'imagen',
        'precio_neto',
        'precio_venta',
        'stock_actual',
        'stock_minimo',
        'stock_bajo',
        'stock_alto',
    ];

    protected function casts(): array
    {
        return [
            'precio_neto' => 'decimal:2',
            'precio_venta' => 'decimal:2',
            'stock_actual' => 'integer',
            'stock_minimo' => 'integer',
            'stock_bajo' => 'integer',
            'stock_alto' => 'integer',
        ];
    }

    /**
     * Calcula automáticamente el precio con IVA (19%).
     */
    public static function calcularPrecioVenta(float|int $precioNeto): float
    {
        return round($precioNeto * 1.19, 2);
    }
}
