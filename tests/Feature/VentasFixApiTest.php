<?php

namespace Tests\Feature;

use App\Models\Cliente;
use App\Models\Producto;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class VentasFixApiTest extends TestCase
{
    protected User $adminUser;

    protected function setUp(): void
    {
        parent::setUp();

        $this->adminUser = User::firstOrCreate(
            ['email' => 'admin@ventasfix.cl'],
            [
                'rut' => '11.111.111-1',
                'nombre' => 'Admin',
                'apellido' => 'Test',
                'password' => Hash::make('password123'),
            ]
        );
    }

    /**
     * Test 1: Autenticación exitosa en API genera token Bearer.
     */
    public function test_api_login_returns_token(): void
    {
        $response = $this->postJson('/api/v1/auth/login', [
            'email' => 'admin@ventasfix.cl',
            'password' => 'password123',
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'codigo',
                'mensaje',
                'token_tipo',
                'token',
                'usuario',
            ]);
    }

    /**
     * Test 2: Petición sin token a ruta protegida responde 401 Unauthenticated.
     */
    public function test_protected_routes_require_authentication(): void
    {
        $response = $this->getJson('/api/v1/productos');
        $response->assertStatus(401);
    }

    /**
     * Test 3: Listar productos responde HTTP 200.
     */
    public function test_can_list_productos_with_token(): void
    {
        $response = $this->actingAs($this->adminUser, 'sanctum')
            ->getJson('/api/v1/productos');

        $response->assertStatus(200)
            ->assertJsonStructure(['codigo', 'mensaje', 'datos']);
    }

    /**
     * Test 4: Crear producto calcula automáticamente IVA 19% y responde HTTP 201.
     */
    public function test_create_producto_calculates_vat_and_returns_201(): void
    {
        $sku = 'TEST-' . uniqid();
        $response = $this->actingAs($this->adminUser, 'sanctum')
            ->postJson('/api/v1/productos', [
                'sku' => $sku,
                'nombre' => 'Producto de Prueba Automatizada',
                'descripcion_corta' => 'Descripción breve para test',
                'descripcion_larga' => 'Descripción extensa y técnica del producto',
                'imagen' => '/images/products/01.png',
                'precio_neto' => 100000,
                'stock_actual' => 20,
                'stock_minimo' => 5,
                'stock_bajo' => 10,
                'stock_alto' => 50,
            ]);

        $response->assertStatus(201);
        $this->assertEquals(119000, $response->json('datos.precio_venta'));
    }

    /**
     * Test 5: Rechazo de usuario sin dominio @ventasfix.cl con HTTP 422.
     */
    public function test_reject_user_with_invalid_domain_returns_422(): void
    {
        $response = $this->actingAs($this->adminUser, 'sanctum')
            ->postJson('/api/v1/usuarios', [
                'rut' => '20.999.888-1',
                'nombre' => 'Test',
                'apellido' => 'Invalido',
                'email' => 'externo@gmail.com', // Dominio inválido
                'password' => 'password123',
            ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['email']);
    }

    /**
     * Test 6: Crear cliente empresa responde HTTP 201.
     */
    public function test_create_cliente_returns_201(): void
    {
        $rutEmpresa = '79.' . rand(100, 999) . '.' . rand(100, 999) . '-K';
        $response = $this->actingAs($this->adminUser, 'sanctum')
            ->postJson('/api/v1/clientes', [
                'rut_empresa' => $rutEmpresa,
                'rubro' => 'Servicios Informáticos',
                'razon_social' => 'Tech Solutions Corp SpA',
                'telefono' => '+56 9 8888 7777',
                'direccion' => 'Av. Andrés Bello 2457, Providencia',
                'nombre_contacto' => 'Ignacio Morales',
                'email_contacto' => 'imorales@techsolutions.cl',
            ]);

        $response->assertStatus(201)
            ->assertJsonPath('codigo', 201);
    }
}
