<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Cliente')</title>

    <!-- AdminLTE + Bootstrap Styles -->
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/dist/css/adminlte.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">

    <style>
        .content-wrapper { background-color: transparent !important; }
        .main-header.navbar { background-color: #000 !important; border-bottom: none !important; box-shadow: none !important; }
        .navbar-nav .nav-link { color: #fff !important; font-weight: 500; }
        .navbar-nav .nav-link:hover { color: #00c0ff !important; }
        .navbar-brand img {
            max-height: 80px;
            filter: drop-shadow(0 0 6px #00aaff) drop-shadow(0 0 12px #0077cc) drop-shadow(0 0 18px #00e5ff);
            transition: filter 0.3s ease;
        }
        .navbar-brand img:hover { filter: drop-shadow(0 0 12px #00e5ff) drop-shadow(0 0 24px #00cfff); }
        .main-footer { background-color: #000; color: #cccccc; padding: 20px 0; font-weight: 500; }
        .main-footer strong { color: #697679ff; }
    </style>

    @stack('css')
</head>

<body class="hold-transition layout-top-nav">
    <div class="wrapper">

        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand-md">
            <div class="container">
                <a href="{{ route('cliente.inicio') }}" class="navbar-brand d-flex align-items-center">
                    <img src="{{ asset('storage/imagenes/logoStars.png') }}" alt="Logo">
                </a>

                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarCollapse">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item">
                            <a href="{{ route('cliente.inicio') }}" class="nav-link">Inicio</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('cliente.barberos.index') }}" class="nav-link">Barberos</a>
                        </li>

                        {{-- Enlace simple a Productos (el filtrado se ve dentro del index de productos) --}}
                        <li class="nav-item">
                            <a href="{{ route('productos.index') }}" class="nav-link">Productos</a>
                        </li>

                        {{-- Venta (contador desde sesión) --}}
                        <li class="nav-item">
                            <a href="{{ route('cliente.ventas.index') }}" class="nav-link">
                                <i class="fas fa-shopping-cart"></i>
                                Venta
                                <span class="badge badge-light">{{ count(session('venta', [])) }}</span>
                            </a>
                        </li>

                        @auth
                        <li class="nav-item dropdown">
                            <a id="userDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                               data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                {{ Auth::user()->nombre }}
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    Cerrar sesión
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </li>
                        @endauth
                    </ul>
                </div>
            </div>
        </nav>

        <!-- Contenido -->
        <div class="content-wrapper">
            <div class="content">
                @yield('content')
            </div>
        </div>

        <!-- Footer -->
        <footer class="main-footer text-center">
            <strong>&copy; {{ date('Y') }} Barbería.</strong>
        </footer>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('vendor/adminlte/dist/js/adminlte.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js"></script>

    @stack('js')
</body>
</html>
