<div class="startbar d-print-none">
    <!--start brand-->
    <div class="brand">
        <a href="{{ route('dashboard') }}" class="logo d-flex align-items-center text-decoration-none">
            <span class="logo-sm">
                <img src="/images/logo-sm.png" alt="logo-small" height="24">
            </span>
            <span class="logo-lg">
                <img src="/images/logo-sm.png" alt="logo-small" height="24" class="me-2">
                <span class="fs-18 fw-bold text-white">VentasFix</span>
            </span>
        </a>
    </div>
    <!--end brand-->
    <!--start startbar-menu-->
    <div class="startbar-menu">
        <div class="startbar-collapse" id="startbarCollapse" data-simplebar>
            <div class="d-flex align-items-start flex-column w-100">
                <!-- Navigation -->
                <ul class="navbar-nav mb-auto w-100">
                    <li class="menu-label mt-2">
                        <span>Principal</span>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('dashboard') || request()->routeIs('root') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                            <i class="iconoir-report-columns menu-icon"></i>
                            <span>Dashboard</span>
                        </a>
                    </li><!--end nav-item-->

                    <li class="menu-label mt-3">
                        <span>Administración</span>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('usuarios.*') ? 'active' : '' }}" href="{{ route('usuarios.index') }}">
                            <i class="iconoir-group menu-icon"></i>
                            <span>Usuarios</span>
                        </a>
                    </li><!--end nav-item-->

                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('productos.*') ? 'active' : '' }}" href="{{ route('productos.index') }}">
                            <i class="iconoir-shop menu-icon"></i>
                            <span>Productos</span>
                        </a>
                    </li><!--end nav-item-->

                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('clientes.*') ? 'active' : '' }}" href="{{ route('clientes.index') }}">
                            <i class="iconoir-community menu-icon"></i>
                            <span>Clientes</span>
                        </a>
                    </li><!--end nav-item-->

                    <li class="menu-label mt-3">
                        <span>Sesión</span>
                    </li>

                    <li class="nav-item">
                        <form method="POST" action="{{ route('logout') }}" id="sidebar-logout-form" class="d-none">
                            @csrf
                        </form>
                        <a class="nav-link text-danger" href="#" onclick="event.preventDefault(); document.getElementById('sidebar-logout-form').submit();">
                            <i class="iconoir-log-out menu-icon text-danger"></i>
                            <span>Cerrar Sesión</span>
                        </a>
                    </li><!--end nav-item-->
                </ul><!--end navbar-nav--->
            </div>
        </div><!--end startbar-collapse-->
    </div><!--end startbar-menu-->
</div><!--end startbar-->
<div class="startbar-overlay d-print-none"></div>
