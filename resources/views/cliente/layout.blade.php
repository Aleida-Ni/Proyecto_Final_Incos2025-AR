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

        /* HEADER */
        .main-header.navbar {
            background-color: #000 !important;
            border-bottom: none !important;
            box-shadow: none !important;
            flex-direction: column;
            align-items: center;
            padding: 20px 0;
        }
        .navbar-brand img {
            max-height: 90px;
            transition: filter 0.3s ease;
        }
        .navbar-nav {
            flex-direction: row;
            justify-content: center;
            margin-top: 15px;
        }
        .navbar-nav .nav-link {
            color: #fff !important;
            font-weight: 500;
            margin: 0 15px;
        }
        .navbar-nav .nav-link:hover {
            color: #00c0ff !important;
        }

        /* FOOTER */
        .main-footer {
            background-color: #000;
            color: #cccccc;
            padding: 30px 0;
            font-weight: 500;
        }
        .footer-logo img {
            max-height: 80px;
        }
        .footer-links a {
            color: #cccccc;
            margin: 0 15px;
            text-decoration: none;
            font-weight: 500;
        }
        .footer-links a:hover {
            color: #00c0ff !important;
        }
        .footer-social a {
            color: #cccccc;
            margin: 0 10px;
            font-size: 1.3rem;
        }
        .footer-social a:hover {
            color: #00c0ff !important;
        }
    </style>

    @stack('css')
</head>
<body class="hold-transition layout-top-nav">
    <div class="wrapper">

        <!-- HEADER -->
        <nav class="main-header navbar navbar-expand-md">
            <div class="container flex-column text-center">
                <!-- LOGO -->
                <a href="{{ route('cliente.inicio') }}" class="navbar-brand mx-auto">
                    <img src="{{ asset('storage/imagenes/logoStars.png') }}" alt="Logo">
                </a>

                <!-- MENÚ -->
                <div class="collapse navbar-collapse show" id="navbarCollapse">
                    <ul class="navbar-nav mx-auto">
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

        <!-- CONTENIDO -->
        <div class="content-wrapper">
            <div class="content">
                @yield('content')
            </div>
        </div>

        <!-- FOOTER -->
        <footer class="main-footer text-center">
            <div class="container">
                <!-- LOGO -->
                <div class="footer-logo mb-3">
                    <img src="{{ asset('storage/imagenes/logoStars.png') }}" alt="Logo">
                </div>

                <!-- LINKS -->
                <div class="footer-links mb-3">
                    <a href="{{ route('cliente.inicio') }}">Inicio</a>
                    <a href="{{ route('cliente.barberos.index') }}">Barberos</a>
                    <a href="{{ route('cliente.productos.index') }}">Productos</a>
                </div>

                <!-- REDES -->
                <div class="footer-social mb-3">
                    <a href="#"><i class="fab fa-facebook"></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                    <a href="#"><i class="fab fa-whatsapp"></i></a>
                </div>

                <!-- COPYRIGHT -->
                <small>&copy; {{ date('Y') }} Barbería. Todos los derechos reservados.</small>
            </div>
        </footer>
    </div>

    <!-- Scripts Bootstrap 5 + AdminLTE -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('vendor/adminlte/dist/js/adminlte.min.js') }}"></script>
    @stack('js')
</body>
</html>
