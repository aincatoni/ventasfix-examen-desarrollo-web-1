@extends('layouts.vertical', ['title' => 'Dashboard - VentasFix'])

@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box d-md-flex justify-content-md-between align-items-center">
            <h4 class="page-title">Dashboard General</h4>
            <div class="">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">VentasFix</a></li>
                    <li class="breadcrumb-item active">Dashboard</li>
                </ol>
            </div>
        </div>
    </div>
</div>

{{-- 4. Requerimientos de Métricas del Dashboard --}}
<div class="row">
    {{-- 4.1 Total Usuarios --}}
    <div class="col-md-6 col-lg-4">
        <div class="card">
            <div class="card-body">
                <div class="row d-flex justify-content-between align-items-center">
                    <div class="col">
                        <p class="text-dark mb-0 fw-semibold fs-14">Usuarios del Sistema</p>
                        <h3 class="my-2 fs-24 fw-bold text-primary">{{ $totalUsuarios }}</h3>
                        <p class="mb-0 text-truncate text-muted">
                            <span class="text-success"><i class="mdi mdi-checkbox-marked-circle-outline me-1"></i>Activos</span> con dominio @ventasfix.cl
                        </p>
                    </div>
                    <div class="col-auto">
                        <div class="d-flex justify-content-center align-items-center thumb-xl bg-primary-subtle text-primary rounded-circle">
                            <i class="iconoir-group fs-24"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer bg-light-subtle py-2">
                <a href="{{ route('usuarios.index') }}" class="text-primary fs-12 fw-medium">Ver mantenedor de usuarios <i class="las la-arrow-right ms-1"></i></a>
            </div>
        </div>
    </div>

    {{-- 4.2 Total Productos --}}
    <div class="col-md-6 col-lg-4">
        <div class="card">
            <div class="card-body">
                <div class="row d-flex justify-content-between align-items-center">
                    <div class="col">
                        <p class="text-dark mb-0 fw-semibold fs-14">Catálogo de Productos</p>
                        <h3 class="my-2 fs-24 fw-bold text-success">{{ $totalProductos }}</h3>
                        <p class="mb-0 text-truncate text-muted">
                            <span class="text-info"><i class="mdi mdi-tag-outline me-1"></i>Con IVA (19%)</span> sincronizados
                        </p>
                    </div>
                    <div class="col-auto">
                        <div class="d-flex justify-content-center align-items-center thumb-xl bg-success-subtle text-success rounded-circle">
                            <i class="iconoir-shop fs-24"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer bg-light-subtle py-2">
                <a href="{{ route('productos.index') }}" class="text-success fs-12 fw-medium">Ver mantenedor de productos <i class="las la-arrow-right ms-1"></i></a>
            </div>
        </div>
    </div>

    {{-- 4.3 Total Clientes --}}
    <div class="col-md-6 col-lg-4">
        <div class="card">
            <div class="card-body">
                <div class="row d-flex justify-content-between align-items-center">
                    <div class="col">
                        <p class="text-dark mb-0 fw-semibold fs-14">Clientes Empresa</p>
                        <h3 class="my-2 fs-24 fw-bold text-warning">{{ $totalClientes }}</h3>
                        <p class="mb-0 text-truncate text-muted">
                            <span class="text-warning"><i class="mdi mdi-domain me-1"></i>B2B</span> registrados y validados
                        </p>
                    </div>
                    <div class="col-auto">
                        <div class="d-flex justify-content-center align-items-center thumb-xl bg-warning-subtle text-warning rounded-circle">
                            <i class="iconoir-community fs-24"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer bg-light-subtle py-2">
                <a href="{{ route('clientes.index') }}" class="text-warning fs-12 fw-medium">Ver mantenedor de clientes <i class="las la-arrow-right ms-1"></i></a>
            </div>
        </div>
    </div>
</div>

{{-- Estado de la Integración con Softland y API --}}
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h4 class="card-title"><i class="las la-plug text-primary me-1"></i> Integración API Softland & Microservicio</h4>
                    </div>
                    <div class="col-auto">
                        <span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1"><i class="las la-check-circle me-1"></i> Microservicio Conectado</span>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <p class="text-muted mb-2">
                            La plataforma <strong>VentasFix</strong> cuenta con el microservicio REST activo para conectarse al ERP externo <strong>Softland</strong>. Todos los métodos de API están autenticados mediante tokens Bearer (Laravel Sanctum) y validan datos obligatorios con cálculo automático del 19% de IVA.
                        </p>
                        <div class="d-flex flex-wrap gap-2">
                            <span class="badge bg-primary-subtle text-primary">GET|POST|PUT|DELETE /api/v1/usuarios</span>
                            <span class="badge bg-success-subtle text-success">GET|POST|PUT|DELETE /api/v1/productos</span>
                            <span class="badge bg-warning-subtle text-warning">GET|POST|PUT|DELETE /api/v1/clientes</span>
                        </div>
                    </div>
                    <div class="col-md-4 text-md-end mt-3 mt-md-0">
                        <a href="{{ route('productos.index') }}" class="btn btn-primary btn-sm"><i class="las la-plus me-1"></i> Gestionar Productos</a>
                        <a href="{{ route('clientes.index') }}" class="btn btn-outline-secondary btn-sm"><i class="las la-building me-1"></i> Gestionar Clientes</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Tablas Resumen Recientes --}}
<div class="row">
    {{-- Productos Recientes --}}
    <div class="col-lg-7">
        <div class="card">
            <div class="card-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h4 class="card-title">Últimos Productos Registrados</h4>
                    </div>
                    <div class="col-auto">
                        <a href="{{ route('productos.index') }}" class="text-primary fs-12">Ver Todos</a>
                    </div>
                </div>
            </div>
            <div class="card-body pt-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>SKU</th>
                                <th>Nombre</th>
                                <th>Precio Neto</th>
                                <th>Precio Venta (+19% IVA)</th>
                                <th>Stock</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($productosRecientes as $producto)
                                <tr>
                                    <td><span class="badge bg-dark-subtle text-dark">{{ $producto->sku }}</span></td>
                                    <td>{{ $producto->nombre }}</td>
                                    <td>${{ number_format($producto->precio_neto, 0, ',', '.') }}</td>
                                    <td class="fw-bold text-success">${{ number_format($producto->precio_venta, 0, ',', '.') }}</td>
                                    <td>
                                        @if($producto->stock_actual <= $producto->stock_bajo)
                                            <span class="badge bg-danger">{{ $producto->stock_actual }} (Bajo)</span>
                                        @else
                                            <span class="badge bg-success">{{ $producto->stock_actual }}</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="5" class="text-center text-muted">No hay productos registrados.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- Clientes Recientes --}}
    <div class="col-lg-5">
        <div class="card">
            <div class="card-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h4 class="card-title">Últimos Clientes Empresa</h4>
                    </div>
                    <div class="col-auto">
                        <a href="{{ route('clientes.index') }}" class="text-warning fs-12">Ver Todos</a>
                    </div>
                </div>
            </div>
            <div class="card-body pt-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>RUT Empresa</th>
                                <th>Razón Social</th>
                                <th>Contacto</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($clientesRecientes as $cliente)
                                <tr>
                                    <td><span class="badge bg-warning-subtle text-warning">{{ $cliente->rut_empresa }}</span></td>
                                    <td>{{ $cliente->razon_social }}</td>
                                    <td>{{ $cliente->nombre_contacto }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="3" class="text-center text-muted">No hay clientes registrados.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
