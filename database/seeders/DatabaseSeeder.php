<?php

namespace Database\Seeders;

use App\Models\Cliente;
use App\Models\Producto;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Usuarios con dominio @ventasfix.cl y clave cifrada
        User::create([
            'rut' => '11.111.111-1',
            'nombre' => 'Administrador',
            'apellido' => 'VentasFix',
            'email' => 'admin@ventasfix.cl',
            'password' => Hash::make('password123'),
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
        ]);

        User::create([
            'rut' => '12.345.678-9',
            'nombre' => 'Ain',
            'apellido' => 'Cortés',
            'email' => 'acortes@ventasfix.cl',
            'password' => Hash::make('password123'),
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
        ]);

        User::create([
            'rut' => '18.765.432-1',
            'nombre' => 'Carlos',
            'apellido' => 'Mendoza',
            'email' => 'cmendoza@ventasfix.cl',
            'password' => Hash::make('password123'),
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
        ]);

        // 2. Productos iniciales (precios netos y cálculo de IVA al 19%)
        $productos = [
            [
                'sku' => 'PRD-001',
                'nombre' => 'Laptop Profesional ProBook 15"',
                'descripcion_corta' => 'Laptop Intel Core i7 16GB RAM 512GB SSD',
                'descripcion_larga' => 'Equipo de alto rendimiento para trabajadores y desarrolladores con pantalla FHD IPS y teclado retroiluminado.',
                'imagen' => '/images/products/01.png',
                'precio_neto' => 650000,
                'precio_venta' => 773500, // 650000 * 1.19
                'stock_actual' => 25,
                'stock_minimo' => 5,
                'stock_bajo' => 10,
                'stock_alto' => 50,
            ],
            [
                'sku' => 'PRD-002',
                'nombre' => 'Monitor Gamer 27" QHD 165Hz',
                'descripcion_corta' => 'Monitor 27 pulgadas resolución 2K y 1ms',
                'descripcion_larga' => 'Panel IPS ultra rápido compatible con FreeSync y G-Sync, puertos HDMI 2.1 y DisplayPort.',
                'imagen' => '/images/products/02.png',
                'precio_neto' => 210000,
                'precio_venta' => 249900, // 210000 * 1.19
                'stock_actual' => 18,
                'stock_minimo' => 3,
                'stock_bajo' => 6,
                'stock_alto' => 30,
            ],
            [
                'sku' => 'PRD-003',
                'nombre' => 'Teclado Mecánico RGB Inalámbrico',
                'descripcion_corta' => 'Switches Red silenciosos con conexión Bluetooth y 2.4GHz',
                'descripcion_larga' => 'Diseño compacto tenkeyless con chasis de aluminio, batería recargable de 4000mAh y teclas PBT doble inyección.',
                'imagen' => '/images/products/03.png',
                'precio_neto' => 55000,
                'precio_venta' => 65450, // 55000 * 1.19
                'stock_actual' => 42,
                'stock_minimo' => 8,
                'stock_bajo' => 15,
                'stock_alto' => 80,
            ],
            [
                'sku' => 'PRD-004',
                'nombre' => 'Mouse Ergonómico Vertical',
                'descripcion_corta' => 'Sensor óptico 4000 DPI antifatiga',
                'descripcion_larga' => 'Diseñado para prevenir el síndrome del túnel carpiano en jornadas de oficina extendidas.',
                'imagen' => '/images/products/04.png',
                'precio_neto' => 28000,
                'precio_venta' => 33320, // 28000 * 1.19
                'stock_actual' => 60,
                'stock_minimo' => 10,
                'stock_bajo' => 20,
                'stock_alto' => 100,
            ],
        ];

        foreach ($productos as $producto) {
            Producto::create($producto);
        }

        // 3. Clientes iniciales (clientes empresa)
        $clientes = [
            [
                'rut_empresa' => '76.123.456-7',
                'rubro' => 'Tecnología y Telecomunicaciones',
                'razon_social' => 'Inversiones Tecnológicas SpA',
                'telefono' => '+56 9 8765 4321',
                'direccion' => 'Av. Providencia 1234, Of. 601, Santiago',
                'nombre_contacto' => 'Mariana Valenzuela',
                'email_contacto' => 'mvalenzuela@invertech.cl',
            ],
            [
                'rut_empresa' => '77.987.654-3',
                'rubro' => 'Servicios Financieros',
                'razon_social' => 'Consultores Financieros del Sur Ltda.',
                'telefono' => '+56 2 2345 6789',
                'direccion' => 'Calle Agustinas 853, Santiago Centro',
                'nombre_contacto' => 'Rodrigo Tapia',
                'email_contacto' => 'rtapia@consulsur.cl',
            ],
            [
                'rut_empresa' => '78.555.444-2',
                'rubro' => 'Logística y Distribución',
                'razon_social' => 'Transportes y Cargas Rápidas S.A.',
                'telefono' => '+56 9 9123 4567',
                'direccion' => 'Camino a Melipilla 4500, Maipú',
                'nombre_contacto' => 'Camila Fuentes',
                'email_contacto' => 'cfuentes@cargasrapidas.cl',
            ],
        ];

        foreach ($clientes as $cliente) {
            Cliente::create($cliente);
        }
    }
}
