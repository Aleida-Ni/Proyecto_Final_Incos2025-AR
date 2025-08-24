<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Cliente')</title>

    <!-- AdminLTE + FontAwesome + Bootstrap 5 -->
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/dist/css/adminlte.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        .content-wrapper { background-color: transparent !important; }
        .main-header.navbar { background-color: #000 !important; border-bottom: none !important; box-shadow: none !important; }
        .navbar-nav .nav-link { color: #fff !important; font-weight: 500; }
        .navbar-nav .nav-link:hover { color: #00c0ff !important; }
        .navbar-brand img { max-height: 80px; transition: filter 0.3s ease; }
        .main-footer { background-color: #000; color: #cccccc; padding: 20px 0; font-weight: 500; }
    </style>

    @stack('css')
</head>
<body class="hold-transition layout-top-nav">
    <div class="wrapper">
        <nav class="main-header navbar navbar-expand-md">
            <div class="container">
                <a href="{{ route('cliente.inicio') }}" class="navbar-brand d-flex align-items-center">
                    <img src="{{ asset('storage/imagenes/logoStars.png') }}" alt="Logo">
                </a>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarCollapse">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item"><a href="{{ route('cliente.inicio') }}" class="nav-link">Inicio</a></li>
                        <li class="nav-item"><a href="{{ route('cliente.barberos.index') }}" class="nav-link">Barberos</a></li>
                        <li class="nav-item"><a href="{{ route('cliente.productos.index') }}" class="nav-link">Productos</a></li>

                        @auth
                        <li class="nav-item dropdown">
                            <a id="userDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                               data-bs-toggle="dropdown" aria-expanded="false">{{ Auth::user()->nombre }}</a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        Cerrar sesión
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
                                </li>
                            </ul>
                        </li>
                        @endauth
                    </ul>
                </div>
            </div>
        </nav>

        <div class="content-wrapper">
            <div class="content">
                @yield('content')
            </div>
        </div>

        <footer class="main-footer text-center">
            <strong>&copy; {{ date('Y') }} Barbería.</strong>
        </footer>
    </div>

    <!-- Scripts Bootstrap 5 + AdminLTE -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('vendor/adminlte/dist/js/adminlte.min.js') }}"></script>
    @stack('js')
</body>
</html>
