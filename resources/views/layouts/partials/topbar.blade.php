<div class="topbar d-print-none">
    <div class="container-fluid">
        <nav class="topbar-custom d-flex justify-content-between" id="topbar-custom">

            <ul class="topbar-item list-unstyled d-inline-flex align-items-center mb-0">
                <li>
                    <button class="nav-link mobile-menu-btn nav-icon" id="togglemenu" title="Colapsar menú">
                        <i class="iconoir-menu"></i>
                    </button>
                </li>
                <li class="d-none d-md-block ms-2">
                    <span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1 fs-12">
                        <i class="las la-check-circle me-1"></i>Microservicio ERP Softland: Activo
                    </span>
                </li>
            </ul>
            <ul class="topbar-item list-unstyled d-inline-flex align-items-center mb-0">

                <li class="topbar-item">
                    <a class="nav-link nav-icon" href="javascript:void(0);" id="light-dark-mode" title="Cambiar tema claro/oscuro">
                        <i class="iconoir-half-moon dark-mode"></i>
                        <i class="iconoir-sun-light light-mode"></i>
                    </a>
                </li>

                <li class="dropdown topbar-item">
                    <a class="nav-link dropdown-toggle arrow-none nav-icon" data-bs-toggle="dropdown" href="#" role="button"
                        aria-haspopup="false" aria-expanded="false" data-bs-offset="0,19">
                        <img src="/images/users/avatar-1.jpg" alt="Avatar" class="thumb-md rounded-circle">
                    </a>
                    <div class="dropdown-menu dropdown-menu-end py-0 shadow">
                        <div class="d-flex align-items-center dropdown-item py-2 bg-secondary-subtle">
                            <div class="flex-shrink-0">
                                <img src="/images/users/avatar-1.jpg" alt="Avatar" class="thumb-md rounded-circle">
                            </div>
                            <div class="flex-grow-1 ms-2 text-truncate align-self-center">
                                <h6 class="my-0 fw-medium text-dark fs-13">{{ Auth::user()->nombre ?? 'Usuario' }} {{ Auth::user()->apellido ?? '' }}</h6>
                                <small class="text-muted mb-0">{{ Auth::user()->email ?? '' }}</small>
                            </div><!--end media-body-->
                        </div>
                        <div class="dropdown-divider mt-0"></div>
                        <small class="text-muted px-2 pb-1 d-block text-uppercase fs-11">Navegación</small>
                        <a class="dropdown-item" href="{{ route('dashboard') }}"><i class="las la-chart-bar fs-18 me-1 align-text-bottom"></i> Dashboard</a>
                        <a class="dropdown-item" href="{{ route('usuarios.index') }}"><i class="las la-user-tie fs-18 me-1 align-text-bottom"></i> Usuarios</a>
                        <a class="dropdown-item" href="{{ route('productos.index') }}"><i class="las la-boxes fs-18 me-1 align-text-bottom"></i> Productos</a>
                        <a class="dropdown-item" href="{{ route('clientes.index') }}"><i class="las la-building fs-18 me-1 align-text-bottom"></i> Clientes</a>
                        <div class="dropdown-divider mb-0"></div>
                        <form method="POST" action="{{ route('logout') }}" id="logout-form-topbar" class="d-none">
                            @csrf
                        </form>
                        <a class="dropdown-item text-danger" href="#" onclick="event.preventDefault(); document.getElementById('logout-form-topbar').submit();">
                            <i class="las la-power-off fs-18 me-1 align-text-bottom"></i> Cerrar Sesión
                        </a>
                    </div>
                </li>
            </ul><!--end topbar-nav-->
        </nav>
        <!-- end navbar-->
    </div>
</div>
