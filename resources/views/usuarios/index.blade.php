@extends('layouts.vertical', ['title' => 'Mantenedor de Usuarios - VentasFix'])

@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box d-md-flex justify-content-md-between align-items-center">
            <h4 class="page-title">Mantenedor de Usuarios</h4>
            <div class="">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">VentasFix</a></li>
                    <li class="breadcrumb-item active">Usuarios</li>
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
                        <h4 class="card-title">Listado de Usuarios del Sistema</h4>
                        <p class="text-muted mb-0">Todos los usuarios deben pertenecer al dominio <code>@ventasfix.cl</code></p>
                    </div>
                    <div class="col-auto">
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalCrearUsuario">
                            <i class="las la-user-plus me-1"></i> Agregar Nuevo Usuario
                        </button>
                    </div>
                </div>
            </div>
            <div class="card-body pt-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>RUT</th>
                                <th>Nombre Completo</th>
                                <th>Email (Username)</th>
                                <th>Fecha Registro</th>
                                <th class="text-end">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($usuarios as $user)
                                <tr>
                                    <td><span class="badge bg-secondary-subtle text-secondary">{{ $user->id }}</span></td>
                                    <td><strong>{{ $user->rut }}</strong></td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-sm bg-primary-subtle text-primary rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 32px; height: 32px;">
                                                <i class="las la-user"></i>
                                            </div>
                                            <span>{{ $user->nombre }} {{ $user->apellido }}</span>
                                        </div>
                                    </td>
                                    <td><code>{{ $user->email }}</code></td>
                                    <td>{{ $user->created_at ? $user->created_at->format('d/m/Y H:i') : '-' }}</td>
                                    <td class="text-end">
                                        <button class="btn btn-sm btn-outline-info me-1 btn-editar"
                                            data-id="{{ $user->id }}"
                                            data-rut="{{ $user->rut }}"
                                            data-nombre="{{ $user->nombre }}"
                                            data-apellido="{{ $user->apellido }}"
                                            data-email="{{ $user->email }}"
                                            data-bs-toggle="modal"
                                            data-bs-target="#modalEditarUsuario">
                                            <i class="las la-pen"></i> Editar
                                        </button>
                                        <button type="button" 
                                            class="btn btn-sm btn-outline-danger btn-eliminar-usuario"
                                            data-id="{{ $user->id }}"
                                            data-nombre="{{ $user->nombre }} {{ $user->apellido }}"
                                            data-bs-toggle="modal"
                                            data-bs-target="#modalEliminarUsuario">
                                            <i class="las la-trash"></i> Eliminar
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted py-4">No se encontraron usuarios registrados.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-3 d-flex justify-content-end">
                    {{ $usuarios->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Modal Crear Usuario --}}
<div class="modal fade" id="modalCrearUsuario" tabindex="-1" aria-labelledby="modalCrearUsuarioLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="formCrearUsuario" action="{{ route('usuarios.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="modalCrearUsuarioLabel"><i class="las la-user-plus me-1 text-primary"></i> Agregar Usuario</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="rut" class="form-label">RUT <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="rut" name="rut" placeholder="Ej: 12.345.678-9" required value="{{ old('rut') }}">
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="nombre" class="form-label">Nombre <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre" required value="{{ old('nombre') }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="apellido" class="form-label">Apellido <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="apellido" name="apellido" placeholder="Apellido" required value="{{ old('apellido') }}">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email Corporativo (Username) <span class="text-danger">*</span></label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="usuario@ventasfix.cl" required value="{{ old('email') }}">
                        <div class="invalid-feedback">
                            El correo debe pertenecer estrictamente al dominio corporativo <strong>@ventasfix.cl</strong>.
                        </div>
                        <div class="valid-feedback">
                            <i class="las la-check"></i> Dominio corporativo @ventasfix.cl válido.
                        </div>
                        <small class="text-muted">Debe terminar estrictamente en <code>@ventasfix.cl</code></small>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Contraseña <span class="text-danger">*</span></label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Mínimo 6 caracteres" required>
                        <small class="text-muted">La contraseña será cifrada con Bcrypt en la base de datos.</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary"><i class="las la-save me-1"></i> Guardar Usuario</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Modal Editar Usuario --}}
<div class="modal fade" id="modalEditarUsuario" tabindex="-1" aria-labelledby="modalEditarUsuarioLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="formEditarUsuario" action="" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title" id="modalEditarUsuarioLabel"><i class="las la-user-edit me-1 text-info"></i> Editar Usuario</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="edit_rut" class="form-label">RUT <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="edit_rut" name="rut" required>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="edit_nombre" class="form-label">Nombre <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="edit_nombre" name="nombre" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="edit_apellido" class="form-label">Apellido <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="edit_apellido" name="apellido" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="edit_email" class="form-label">Email Corporativo (Username) <span class="text-danger">*</span></label>
                        <input type="email" class="form-control" id="edit_email" name="email" required>
                        <div class="invalid-feedback">
                            El correo debe pertenecer estrictamente al dominio corporativo <strong>@ventasfix.cl</strong>.
                        </div>
                        <div class="valid-feedback">
                            <i class="las la-check"></i> Dominio corporativo @ventasfix.cl válido.
                        </div>
                        <small class="text-muted">Debe terminar estrictamente en <code>@ventasfix.cl</code></small>
                    </div>
                    <div class="mb-3">
                        <label for="edit_password" class="form-label">Nueva Contraseña (Opcional)</label>
                        <input type="password" class="form-control" id="edit_password" name="password" placeholder="Dejar en blanco para mantener la actual">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-info"><i class="las la-save me-1"></i> Actualizar Usuario</button>
                </div>
            </form>
        </div>
    </div>
</div>
{{-- Modal Eliminar Usuario --}}
<div class="modal fade" id="modalEliminarUsuario" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="formEliminarUsuario" action="" method="POST">
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
                    <p class="text-muted mb-0">¿Está seguro de que desea eliminar al usuario <strong id="delete_user_nombre" class="text-dark"></strong>?</p>
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
    // Validación en tiempo real del dominio corporativo @ventasfix.cl
    function setupDomainValidation(inputId, formId) {
        const input = document.getElementById(inputId);
        const form = document.getElementById(formId);
        if (!input) return;

        const domainRegex = /^[a-zA-Z0-9._%+-]+@ventasfix\.cl$/i;

        function validate() {
            const val = input.value.trim();
            if (val === '') {
                input.classList.remove('is-valid', 'is-invalid');
                return false;
            }

            if (domainRegex.test(val)) {
                input.classList.remove('is-invalid');
                input.classList.add('is-valid');
                return true;
            } else {
                input.classList.remove('is-valid');
                input.classList.add('is-invalid');
                return false;
            }
        }

        input.addEventListener('input', validate);
        input.addEventListener('blur', validate);

        if (form) {
            form.addEventListener('submit', function(e) {
                if (!validate()) {
                    e.preventDefault();
                    e.stopPropagation();
                    input.focus();
                }
            });
        }
    }

    setupDomainValidation('email', 'formCrearUsuario');
    setupDomainValidation('edit_email', 'formEditarUsuario');

    // Limpiar validaciones al abrir modal crear
    const modalCrear = document.getElementById('modalCrearUsuario');
    if (modalCrear) {
        modalCrear.addEventListener('show.bs.modal', function() {
            const input = document.getElementById('email');
            if (input && !input.value) {
                input.classList.remove('is-valid', 'is-invalid');
            }
        });
    }

    // Poblar modal editar
    document.querySelectorAll('.btn-editar').forEach(btn => {
        btn.addEventListener('click', function() {
            const id = this.dataset.id;
            const rut = this.dataset.rut;
            const nombre = this.dataset.nombre;
            const apellido = this.dataset.apellido;
            const email = this.dataset.email;

            const form = document.getElementById('formEditarUsuario');
            form.action = `/usuarios/${id}`;
            document.getElementById('edit_rut').value = rut;
            document.getElementById('edit_nombre').value = nombre;
            document.getElementById('edit_apellido').value = apellido;

            const editEmail = document.getElementById('edit_email');
            editEmail.value = email;
            editEmail.classList.remove('is-invalid');
            editEmail.classList.add('is-valid');

            document.getElementById('edit_password').value = '';
        });
    });

    // Poblar modal eliminar
    document.querySelectorAll('.btn-eliminar-usuario').forEach(btn => {
        btn.addEventListener('click', function() {
            const id = this.dataset.id;
            const nombre = this.dataset.nombre;
            const form = document.getElementById('formEliminarUsuario');
            form.action = `/usuarios/${id}`;
            document.getElementById('delete_user_nombre').textContent = nombre;
        });
    });
</script>
@endsection
@endsection
