@extends('layouts.vertical', ['title' => 'Mantenedor de Clientes - VentasFix'])

@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box d-md-flex justify-content-md-between align-items-center">
            <h4 class="page-title">Mantenedor de Clientes Empresa</h4>
            <div class="">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">VentasFix</a></li>
                    <li class="breadcrumb-item active">Clientes</li>
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
                        <h4 class="card-title">Listado de Clientes Empresa</h4>
                        <p class="text-muted mb-0">Gestión de cartera B2B de VentasFix con validación externa en Softland.</p>
                    </div>
                    <div class="col-auto">
                        <button class="btn btn-warning text-dark" data-bs-toggle="modal" data-bs-target="#modalCrearCliente">
                            <i class="las la-building me-1"></i> Agregar Nuevo Cliente Empresa
                        </button>
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
                                <th>Rubro</th>
                                <th>Teléfono</th>
                                <th>Dirección</th>
                                <th>Persona de Contacto</th>
                                <th class="text-end">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($clientes as $cli)
                                <tr>
                                    <td><span class="badge bg-warning-subtle text-warning border border-warning-subtle">{{ $cli->rut_empresa }}</span></td>
                                    <td><strong>{{ $cli->razon_social }}</strong></td>
                                    <td><span class="badge bg-light text-dark border">{{ $cli->rubro }}</span></td>
                                    <td><small>{{ $cli->telefono }}</small></td>
                                    <td><small class="text-muted">{{ $cli->direccion }}</small></td>
                                    <td>
                                        <div><strong>{{ $cli->nombre_contacto }}</strong></div>
                                        <small class="text-muted"><a href="mailto:{{ $cli->email_contacto }}">{{ $cli->email_contacto }}</a></small>
                                    </td>
                                    <td class="text-end">
                                        <button class="btn btn-sm btn-outline-info me-1 btn-editar-cli"
                                            data-id="{{ $cli->id }}"
                                            data-rut="{{ $cli->rut_empresa }}"
                                            data-rubro="{{ $cli->rubro }}"
                                            data-razon="{{ $cli->razon_social }}"
                                            data-telefono="{{ $cli->telefono }}"
                                            data-direccion="{{ $cli->direccion }}"
                                            data-contacto_nombre="{{ $cli->nombre_contacto }}"
                                            data-contacto_email="{{ $cli->email_contacto }}"
                                            data-bs-toggle="modal"
                                            data-bs-target="#modalEditarCliente">
                                            <i class="las la-pen"></i> Editar
                                        </button>
                                        <button type="button" 
                                            class="btn btn-sm btn-outline-danger btn-eliminar-cli"
                                            data-id="{{ $cli->id }}"
                                            data-nombre="{{ $cli->razon_social }}"
                                            data-bs-toggle="modal"
                                            data-bs-target="#modalEliminarCliente">
                                            <i class="las la-trash"></i> Eliminar
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted py-4">No se encontraron clientes registrados.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-3 d-flex justify-content-end">
                    {{ $clientes->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Modal Crear Cliente --}}
<div class="modal fade" id="modalCrearCliente" tabindex="-1" aria-labelledby="modalCrearClienteLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="{{ route('clientes.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="modalCrearClienteLabel"><i class="las la-building me-1 text-warning"></i> Agregar Cliente Empresa</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-5 mb-3">
                            <label for="rut_empresa" class="form-label">RUT Empresa <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="rut_empresa" name="rut_empresa" placeholder="Ej: 76.123.456-7" required value="{{ old('rut_empresa') }}">
                        </div>
                        <div class="col-md-7 mb-3">
                            <label for="razon_social" class="form-label">Razón Social <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="razon_social" name="razon_social" placeholder="Nombre legal de la empresa" required value="{{ old('razon_social') }}">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="rubro" class="form-label">Rubro <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="rubro" name="rubro" placeholder="Ej: Minería, Tecnología, Retail" required value="{{ old('rubro') }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="telefono" class="form-label">Teléfono <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="telefono" name="telefono" placeholder="+56 9 1234 5678" required value="{{ old('telefono') }}">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="direccion" class="form-label">Dirección <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="direccion" name="direccion" placeholder="Calle, Número, Comuna, Ciudad" required value="{{ old('direccion') }}">
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="nombre_contacto" class="form-label">Nombre de la Persona de Contacto <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="nombre_contacto" name="nombre_contacto" placeholder="Nombre completo" required value="{{ old('nombre_contacto') }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="email_contacto" class="form-label">Email de la Persona de Contacto <span class="text-danger">*</span></label>
                            <input type="email" class="form-control" id="email_contacto" name="email_contacto" placeholder="contacto@empresa.cl" required value="{{ old('email_contacto') }}">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-warning text-dark"><i class="las la-save me-1"></i> Guardar Cliente</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Modal Editar Cliente --}}
<div class="modal fade" id="modalEditarCliente" tabindex="-1" aria-labelledby="modalEditarClienteLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="formEditarCliente" action="" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title" id="modalEditarClienteLabel"><i class="las la-pen me-1 text-info"></i> Editar Cliente Empresa</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-5 mb-3">
                            <label for="edit_rut_empresa" class="form-label">RUT Empresa <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="edit_rut_empresa" name="rut_empresa" required>
                        </div>
                        <div class="col-md-7 mb-3">
                            <label for="edit_razon_social" class="form-label">Razón Social <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="edit_razon_social" name="razon_social" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="edit_rubro" class="form-label">Rubro <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="edit_rubro" name="rubro" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="edit_telefono" class="form-label">Teléfono <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="edit_telefono" name="telefono" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="edit_direccion" class="form-label">Dirección <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="edit_direccion" name="direccion" required>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="edit_nombre_contacto" class="form-label">Nombre de Contacto <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="edit_nombre_contacto" name="nombre_contacto" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="edit_email_contacto" class="form-label">Email de Contacto <span class="text-danger">*</span></label>
                            <input type="email" class="form-control" id="edit_email_contacto" name="email_contacto" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-info"><i class="las la-save me-1"></i> Actualizar Cliente</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Modal Eliminar Cliente --}}
<div class="modal fade" id="modalEliminarCliente" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="formEliminarCliente" action="" method="POST">
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
                    <p class="text-muted mb-0">¿Está seguro de que desea eliminar la empresa cliente <strong id="delete_cli_nombre" class="text-dark"></strong>?</p>
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
    document.querySelectorAll('.btn-editar-cli').forEach(btn => {
        btn.addEventListener('click', function() {
            const id = this.dataset.id;
            const form = document.getElementById('formEditarCliente');
            form.action = `/clientes/${id}`;

            document.getElementById('edit_rut_empresa').value = this.dataset.rut;
            document.getElementById('edit_razon_social').value = this.dataset.razon;
            document.getElementById('edit_rubro').value = this.dataset.rubro;
            document.getElementById('edit_telefono').value = this.dataset.telefono;
            document.getElementById('edit_direccion').value = this.dataset.direccion;
            document.getElementById('edit_nombre_contacto').value = this.dataset.contacto_nombre;
            document.getElementById('edit_email_contacto').value = this.dataset.contacto_email;
        });
    });

    document.querySelectorAll('.btn-eliminar-cli').forEach(btn => {
        btn.addEventListener('click', function() {
            const id = this.dataset.id;
            const nombre = this.dataset.nombre;
            const form = document.getElementById('formEliminarCliente');
            form.action = `/clientes/${id}`;
            document.getElementById('delete_cli_nombre').textContent = nombre;
        });
    });
</script>
@endsection
@endsection
