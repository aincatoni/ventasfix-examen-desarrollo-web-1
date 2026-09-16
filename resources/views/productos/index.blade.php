@extends('layouts.vertical', ['title' => 'Mantenedor de Productos - VentasFix'])

@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box d-md-flex justify-content-md-between align-items-center">
            <h4 class="page-title">Mantenedor de Productos</h4>
            <div class="">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">VentasFix</a></li>
                    <li class="breadcrumb-item active">Productos</li>
                </ol>
            </div>
        </div>
    </div>
</div>

{{-- Mensajes Flash --}}
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="las la-check-circle me-1"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="las la-exclamation-circle me-1"></i> {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <ul class="mb-0">
            @foreach($errors->all() as $err)
                <li>{{ $err }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h4 class="card-title">Catálogo de Productos</h4>
                        <p class="text-muted mb-0">Todos los productos incluyen cálculo de IVA correspondiente al 19% e integración con Softland.</p>
                    </div>
                    <div class="col-auto">
                        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalCrearProducto">
                            <i class="las la-plus-circle me-1"></i> Agregar Nuevo Producto
                        </button>
                    </div>
                </div>
            </div>
            <div class="card-body pt-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>SKU</th>
                                <th>Producto</th>
                                <th>Descripción Corta</th>
                                <th>Precio Neto</th>
                                <th>Precio Venta (+19% IVA)</th>
                                <th>Stocks (Actual / Mín / Bajo / Alto)</th>
                                <th class="text-end">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($productos as $prod)
                                <tr>
                                    <td class="text-nowrap"><span class="badge bg-dark-subtle text-dark">{{ $prod->sku }}</span></td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="{{ $prod->imagen }}" alt="{{ $prod->nombre }}" class="me-2 thumb-md rounded border" onerror="this.src='/images/products/01.png';">
                                            <div>
                                                <h6 class="m-0 fs-13">{{ $prod->nombre }}</h6>
                                                <small class="text-muted">ID: {{ $prod->id }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td><small class="text-muted">{{ Str::limit($prod->descripcion_corta, 40) }}</small></td>
                                    <td class="text-nowrap">${{ number_format($prod->precio_neto, 0, ',', '.') }}</td>
                                    <td class="text-nowrap fw-bold text-success">${{ number_format($prod->precio_venta, 0, ',', '.') }}</td>
                                    <td class="text-nowrap">
                                        @if($prod->stock_actual <= $prod->stock_minimo)
                                            <span class="badge bg-danger" title="Crítico: stock en o bajo el mínimo">{{ $prod->stock_actual }}</span>
                                        @elseif($prod->stock_actual <= $prod->stock_bajo)
                                            <span class="badge bg-warning text-dark" title="Alerta: stock bajo">{{ $prod->stock_actual }}</span>
                                        @elseif($prod->stock_actual > $prod->stock_alto)
                                            <span class="badge bg-info text-white" title="Exceso: stock sobre el nivel alto">{{ $prod->stock_actual }}</span>
                                        @else
                                            <span class="badge bg-success" title="Óptimo: stock normal">{{ $prod->stock_actual }}</span>
                                        @endif
                                        <small class="text-muted">/ {{ $prod->stock_minimo }} / {{ $prod->stock_bajo }} / {{ $prod->stock_alto }}</small>
                                    </td>
                                    <td class="text-end text-nowrap">
                                        <button class="btn btn-sm btn-outline-info me-1 btn-editar-prod"
                                            data-id="{{ $prod->id }}"
                                            data-sku="{{ $prod->sku }}"
                                            data-nombre="{{ $prod->nombre }}"
                                            data-desc_corta="{{ $prod->descripcion_corta }}"
                                            data-desc_larga="{{ $prod->descripcion_larga }}"
                                            data-imagen="{{ $prod->imagen }}"
                                            data-precio_neto="{{ (int) $prod->precio_neto }}"
                                            data-precio_venta="{{ (int) $prod->precio_venta }}"
                                            data-stock_actual="{{ $prod->stock_actual }}"
                                            data-stock_minimo="{{ $prod->stock_minimo }}"
                                            data-stock_bajo="{{ $prod->stock_bajo }}"
                                            data-stock_alto="{{ $prod->stock_alto }}"
                                            data-bs-toggle="modal"
                                            data-bs-target="#modalEditarProducto">
                                            <i class="las la-pen"></i> Editar
                                        </button>
                                        <button type="button" 
                                            class="btn btn-sm btn-outline-danger btn-eliminar-prod"
                                            data-id="{{ $prod->id }}"
                                            data-nombre="{{ $prod->nombre }}"
                                            data-bs-toggle="modal"
                                            data-bs-target="#modalEliminarProducto">
                                            <i class="las la-trash"></i> Eliminar
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted py-4">No se encontraron productos registrados.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4 pt-3 border-top">
                    {{ $productos->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Modal Crear Producto --}}
<div class="modal fade" id="modalCrearProducto" tabindex="-1" aria-labelledby="modalCrearProductoLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="{{ route('productos.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="modalCrearProductoLabel"><i class="las la-plus-circle me-1 text-success"></i> Agregar Nuevo Producto</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="sku" class="form-label">SKU <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="sku" name="sku" placeholder="Ej: PRD-100" required value="{{ old('sku') }}">
                        </div>
                        <div class="col-md-8 mb-3">
                            <label for="nombre_prod" class="form-label">Nombre del Producto <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="nombre_prod" name="nombre" placeholder="Nombre completo" required value="{{ old('nombre') }}">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="descripcion_corta" class="form-label">Descripción Corta <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="descripcion_corta" name="descripcion_corta" placeholder="Resumen breve para catálogo" required value="{{ old('descripcion_corta') }}">
                    </div>
                    <div class="mb-3">
                        <label for="descripcion_larga" class="form-label">Descripción Larga <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="descripcion_larga" name="descripcion_larga" rows="3" placeholder="Detalle técnico y características" required>{{ old('descripcion_larga') }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label for="imagen" class="form-label">Ruta o URL de la Imagen <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="imagen" name="imagen" placeholder="/images/products/01.png" required value="{{ old('imagen', '/images/products/01.png') }}">
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="precio_neto" class="form-label">Precio Neto ($ CLP) <span class="text-danger">*</span></label>
                            <input type="number" step="1" class="form-control" id="precio_neto" name="precio_neto" placeholder="Ej: 100000" required value="{{ old('precio_neto') }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="precio_venta" class="form-label">Precio Venta con IVA 19% ($ CLP)</label>
                            <input type="number" step="1" class="form-control bg-light" id="precio_venta" name="precio_venta" placeholder="Calculado automáticamente (Neto * 1.19)" readonly>
                            <small class="text-success"><i class="las la-calculator"></i> Se calcula automáticamente con IVA 19%.</small>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <label for="stock_actual" class="form-label">Stock Actual <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="stock_actual" name="stock_actual" min="0" required value="{{ old('stock_actual', 0) }}">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="stock_minimo" class="form-label">Stock Mínimo <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="stock_minimo" name="stock_minimo" min="0" required value="{{ old('stock_minimo', 5) }}">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="stock_bajo" class="form-label">Stock Bajo <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="stock_bajo" name="stock_bajo" min="0" required value="{{ old('stock_bajo', 10) }}">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="stock_alto" class="form-label">Stock Alto <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="stock_alto" name="stock_alto" min="0" required value="{{ old('stock_alto', 50) }}">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-success"><i class="las la-save me-1"></i> Guardar Producto</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Modal Editar Producto --}}
<div class="modal fade" id="modalEditarProducto" tabindex="-1" aria-labelledby="modalEditarProductoLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="formEditarProducto" action="" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title" id="modalEditarProductoLabel"><i class="las la-pen me-1 text-info"></i> Editar Producto</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="edit_sku" class="form-label">SKU <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="edit_sku" name="sku" required>
                        </div>
                        <div class="col-md-8 mb-3">
                            <label for="edit_nombre_prod" class="form-label">Nombre del Producto <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="edit_nombre_prod" name="nombre" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="edit_descripcion_corta" class="form-label">Descripción Corta <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="edit_descripcion_corta" name="descripcion_corta" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_descripcion_larga" class="form-label">Descripción Larga <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="edit_descripcion_larga" name="descripcion_larga" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="edit_imagen" class="form-label">Ruta o URL de la Imagen <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="edit_imagen" name="imagen" required>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="edit_precio_neto" class="form-label">Precio Neto ($ CLP) <span class="text-danger">*</span></label>
                            <input type="number" step="1" class="form-control" id="edit_precio_neto" name="precio_neto" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="edit_precio_venta" class="form-label">Precio Venta con IVA 19% ($ CLP)</label>
                            <input type="number" step="1" class="form-control bg-light" id="edit_precio_venta" name="precio_venta" readonly>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <label for="edit_stock_actual" class="form-label">Stock Actual <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="edit_stock_actual" name="stock_actual" min="0" required>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="edit_stock_minimo" class="form-label">Stock Mínimo <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="edit_stock_minimo" name="stock_minimo" min="0" required>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="edit_stock_bajo" class="form-label">Stock Bajo <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="edit_stock_bajo" name="stock_bajo" min="0" required>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="edit_stock_alto" class="form-label">Stock Alto <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="edit_stock_alto" name="stock_alto" min="0" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-info"><i class="las la-save me-1"></i> Actualizar Producto</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Modal Eliminar Producto --}}
<div class="modal fade" id="modalEliminarProducto" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="formEliminarProducto" action="" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-header border-0 pb-0">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center pt-0 pb-3">
                    <div class="mb-3">
                        <i class="las la-exclamation-triangle text-danger" style="font-size: 56px;"></i>
                    </div>
                    <h5 class="modal-title mb-2 fw-semibold">¿Confirmar Eliminación?</h5>
                    <p class="text-muted mb-0">¿Está seguro de que desea eliminar el producto <strong id="delete_prod_nombre" class="text-dark"></strong>?</p>
                    <small class="text-danger d-block mt-2">Esta acción no se puede deshacer.</small>
                </div>
                <div class="modal-footer justify-content-center border-0 pt-0 pb-4">
                    <button type="button" class="btn btn-light px-4" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-danger px-4"><i class="las la-trash me-1"></i> Sí, Eliminar</button>
                </div>
            </form>
        </div>
    </div>
</div>

@section('script')
<script>
    // Cálculo reactivo del IVA 19% en creación
    const inputNeto = document.getElementById('precio_neto');
    const inputVenta = document.getElementById('precio_venta');
    if (inputNeto && inputVenta) {
        inputNeto.addEventListener('input', function() {
            const val = parseFloat(this.value);
            if (!isNaN(val)) {
                inputVenta.value = Math.round(val * 1.19);
            } else {
                inputVenta.value = '';
            }
        });
    }

    // Cálculo reactivo del IVA 19% en edición
    const editNeto = document.getElementById('edit_precio_neto');
    const editVenta = document.getElementById('edit_precio_venta');
    if (editNeto && editVenta) {
        editNeto.addEventListener('input', function() {
            const val = parseFloat(this.value);
            if (!isNaN(val)) {
                editVenta.value = Math.round(val * 1.19);
            } else {
                editVenta.value = '';
            }
        });
    }

    // Poblar modal de edición
    document.querySelectorAll('.btn-editar-prod').forEach(btn => {
        btn.addEventListener('click', function() {
            const id = this.dataset.id;
            const form = document.getElementById('formEditarProducto');
            form.action = `/productos/${id}`;

            document.getElementById('edit_sku').value = this.dataset.sku;
            document.getElementById('edit_nombre_prod').value = this.dataset.nombre;
            document.getElementById('edit_descripcion_corta').value = this.dataset.desc_corta;
            document.getElementById('edit_descripcion_larga').value = this.dataset.desc_larga;
            document.getElementById('edit_imagen').value = this.dataset.imagen;
            document.getElementById('edit_precio_neto').value = Math.round(parseFloat(this.dataset.precio_neto) || 0);
            document.getElementById('edit_precio_venta').value = Math.round(parseFloat(this.dataset.precio_venta) || 0);
            document.getElementById('edit_stock_actual').value = this.dataset.stock_actual;
            document.getElementById('edit_stock_minimo').value = this.dataset.stock_minimo;
            document.getElementById('edit_stock_bajo').value = this.dataset.stock_bajo;
            document.getElementById('edit_stock_alto').value = this.dataset.stock_alto;
        });
    });

    // Poblar modal de eliminación
    document.querySelectorAll('.btn-eliminar-prod').forEach(btn => {
        btn.addEventListener('click', function() {
            const id = this.dataset.id;
            const nombre = this.dataset.nombre;
            const form = document.getElementById('formEliminarProducto');
            form.action = `/productos/${id}`;
            document.getElementById('delete_prod_nombre').textContent = nombre;
        });
    });
</script>
@endsection
@endsection
