<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Logo -->
    <a href="#" class="brand-link">
        <span class="brand-text font-weight-light ml-2">Panel Cliente</span>
    </a>

    <!-- Menú -->
    <div class="sidebar">
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" role="menu">
                <li class="nav-item">
                    <a href="{{ route('cliente.home') }}" class="nav-link">
                        <i class="nav-icon fas fa-home"></i>
                        <p>Inicio</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('cliente.productos') }}" class="nav-link">
                        <i class="nav-icon fas fa-box"></i>
                        <p>Ver Productos</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('cliente.barberos') }}" class="nav-link">
                        <i class="nav-icon fas fa-user-friends"></i>
                        <p>Barberos</p>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</aside>
