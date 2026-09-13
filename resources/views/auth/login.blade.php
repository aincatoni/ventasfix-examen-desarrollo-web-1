@extends('layouts.auth', ['title' => 'Inicio de Sesión - VentasFix'])

@section('content')
    <div class="card shadow-lg border-0">
        <div class="card-body p-0 bg-primary auth-header-box rounded-top">
            <div class="text-center p-4">
                <a href="{{ route('login') }}" class="logo logo-admin">
                    <img src="/images/logo-sm.png" height="55" alt="VentasFix" class="auth-logo mb-2">
                </a>
                <h4 class="mt-2 mb-1 fw-bold text-white fs-20">VentasFix Backoffice</h4>
                <p class="text-white-50 fw-medium mb-0">Sistema de Microservicio y Gestión de Carro de Compra</p>
            </div>
        </div>
        <div class="card-body pt-3 pb-4 px-4">
            {{-- Credenciales de Demostración para Evaluación --}}
            <div class="alert alert-info py-2 px-3 mb-3 fs-13" role="alert">
                <i class="las la-info-circle me-1"></i> <strong>Acceso de Evaluación:</strong><br>
                <span>Email: <code>admin@ventasfix.cl</code></span><br>
                <span>Contraseña: <code>password123</code></span>
            </div>

            <form class="my-2" method="POST" action="{{ route('login') }}">
                @csrf

                @if ($errors->any())
                    <div class="alert alert-danger py-2 px-3 mb-3 fs-13">
                        @foreach ($errors->all() as $error)
                            <p class="mb-0">{{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                <div class="form-group mb-3">
                    <label class="form-label fw-semibold" for="email">Correo Electrónico (Username)</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light"><i class="las la-envelope"></i></span>
                        <input type="email" class="form-control" id="email" placeholder="usuario@ventasfix.cl"
                               name="email" value="{{ old('email', 'admin@ventasfix.cl') }}" required autofocus>
                    </div>
                    <small class="text-muted">Usuarios corporativos <code>@ventasfix.cl</code></small>
                </div>

                <div class="form-group mb-3">
                    <label class="form-label fw-semibold" for="password">Contraseña</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light"><i class="las la-lock"></i></span>
                        <input type="password" class="form-control" name="password" id="password"
                               placeholder="Contraseña cifrada" value="password123" required>
                    </div>
                </div>

                <div class="form-group row mb-3">
                    <div class="col-12">
                        <div class="form-check form-switch form-switch-primary">
                            <input class="form-check-input" type="checkbox" id="remember_me" name="remember" checked>
                            <label class="form-check-label fs-13" for="remember_me">Recordar credenciales</label>
                        </div>
                    </div>
                </div>

                <div class="form-group mb-0 row">
                    <div class="col-12">
                        <div class="d-grid mt-2">
                            <button class="btn btn-primary btn-lg fs-15 fw-semibold" type="submit">
                                Iniciar Sesión <i class="las la-sign-in-alt ms-1"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </form>

            <div class="text-center mt-3">
                <small class="text-muted">Desarrollado para VentasFix & Softland ERP • Examen Web I</small>
            </div>
        </div>
    </div>
@endsection
