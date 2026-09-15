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
            'precio_neto' => 'integer',
            'precio_venta' => 'integer',
            'stock_actual' => 'integer',
            'stock_minimo' => 'integer',
            'stock_bajo' => 'integer',
            'stock_alto' => 'integer',
        ];
    }

    /**
     * Calcula automáticamente el precio con IVA (19%).
     */
    public static function calcularPrecioVenta(float|int $precioNeto): int
    {
        return (int) round($precioNeto * 1.19);
    }
}
