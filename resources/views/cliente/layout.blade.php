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
        body {
            background-color: #fff !important;
        }
        .content-wrapper { 
            background-color: transparent !important; 
        }

        /* HEADER - ESTADO INICIAL (BLANCO) */
        .main-header.navbar {
            background-color: #fff !important;
            border-bottom: 1px solid #e0e0e0 !important;
            box-shadow: none !important;
            flex-direction: column;
            align-items: center;
            padding: 20px 0;
            transition: all 0.3s ease;
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 1000;
        }

        /* Header cuando hace scroll (NEGRO) */
        .main-header.navbar.scrolled {
            background-color: #000 !important;
            padding: 10px 0;
        }

        .navbar-brand img {
            max-height: 90px;
            transition: all 0.3s ease;
        }

        /* Logo con destellos */
        .logo-sparkle { position: relative; display: inline-block; }
        .logo-sparkle img { 
            display: block;     
            filter: drop-shadow(0 0 8px rgba(11, 11, 11, 0.5)); /* sombra negra por defecto */
            transition: filter 0.3s ease;}
        /* Destello por defecto: oscuro/contraste para fondo claro */
        .logo-sparkle .sparkles {
            position: absolute;
            inset: 0;
            pointer-events: none;
            border-radius: 8px;
            mix-blend-mode: multiply; /* multiply para destellos oscuros sobre fondo claro */
            background-image: radial-gradient(2px 2px at 10% 20%, rgba(0,0,0,0.55), rgba(0,0,0,0)), radial-gradient(2px 2px at 70% 40%, rgba(0,0,0,0.45), rgba(0,0,0,0)), radial-gradient(1.6px 1.6px at 40% 80%, rgba(0,0,0,0.35), rgba(0,0,0,0));
            opacity: 0.95;
            animation: sparkle-move 3.2s linear infinite;
            filter: drop-shadow(0 0 6px rgba(0,0,0,0.15));
        }

        /* Cuando el header esté scrolled (fondo oscuro), usar destello claro/azulado */
        .main-header.navbar.scrolled .logo-sparkle .sparkles {
            mix-blend-mode: screen;
            background-image: radial-gradient(2px 2px at 10% 20%, rgba(255,255,255,0.95), rgba(255,255,255,0)), radial-gradient(2px 2px at 70% 40%, rgba(0,207,255,0.95), rgba(0,207,255,0)), radial-gradient(1.6px 1.6px at 40% 80%, rgba(255,255,255,0.9), rgba(255,255,255,0));
            filter: drop-shadow(0 0 8px rgba(0,207,255,0.25));
            opacity: 0.9;
        }

        @keyframes sparkle-move {
            0% { transform: translateY(0) scale(1); opacity: 0.6; }
            25% { transform: translateY(-3px) scale(1.02); opacity: 1; }
            50% { transform: translateY(0) scale(1); opacity: 0.7; }
            75% { transform: translateY(2px) scale(0.98); opacity: 1; }
            100% { transform: translateY(0) scale(1); opacity: 0.6; }
        }

        .main-header.navbar.scrolled .navbar-brand img {
            max-height: 60px;
        }

        .navbar-nav .nav-link {
            color: #333 !important;
            font-weight: 500;
            margin: 0 15px;
            transition: color 0.3s ease;
        }

        /* Cambio de color de enlaces cuando hace scroll */
        .main-header.navbar.scrolled .navbar-nav .nav-link {
            color: #fff !important;
        }

        .navbar-nav .nav-link:hover {
            color: #00c0ff !important;
        }

        /* Dropdown inicial (oscuro) */
        .dropdown-menu {
            background-color: #333;
        }
        .dropdown-item {
            color: #fff;
        }
        .dropdown-item:hover {
            background-color: #00c0ff;
            color: #000;
        }

        /* Ajuste del contenido para el header fijo */
        .content-wrapper {
            margin-top: 180px; /* Espacio para el header inicial */
        }

        .main-header.navbar.scrolled ~ .content-wrapper {
            margin-top: 120px; /* Espacio reducido cuando el header es más pequeño */
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
                    <span class="logo-sparkle">
                        <img src="{{ asset('storage/imagenes/logoStars.png') }}" alt="Logo">
                        <span class="sparkles" aria-hidden="true"></span>
                    </span>
                </a>

                <!-- MENÚ -->
                <div class="collapse navbar-collapse show" id="navbarCollapse">
                    <ul class="navbar-nav mx-auto">
                        <li class="nav-item"><a href="{{ route('cliente.inicio') }}" class="nav-link">INICIO</a></li>
                        <li class="nav-item"><a href="{{ route('cliente.barberos.index') }}" class="nav-link">RESERVA TU CITA</a></li>
                        <li class="nav-item"><a href="{{ route('cliente.productos.index') }}" class="nav-link">TIENDA</a></li>

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
                    <span class="logo-sparkle">
                        <img src="{{ asset('storage/imagenes/logoStars.png') }}" alt="Logo">
                        <span class="sparkles" aria-hidden="true"></span>
                    </span>
                </div>

                <!-- LINKS -->
                <div class="footer-links mb-3">
                    <a href="{{ route('cliente.inicio') }}">INICIO</a>
                    <a href="{{ route('cliente.barberos.index') }}">BARBEROS</a>
                    <a href="{{ route('cliente.productos.index') }}">TIENDA</a>
                </div>

                <!-- REDES -->
                <div class="footer-social mb-3">
                    <a href="#"><i class="fab fa-facebook"></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                    <a href="#"><i class="fab fa-whatsapp"></i></a>
                </div>

                <!-- COPYRIGHT -->
                <small>&copy; {{ date('Y') }} Barbe Shop. Todos los derechos reservados.</small>
            </div>
        </footer>
    </div>

    <!-- Scripts Bootstrap 5 + AdminLTE -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('vendor/adminlte/dist/js/adminlte.min.js') }}"></script>

    <script>
        // Efecto de cambio en el header al hacer scroll
        window.addEventListener('scroll', function() {
            const header = document.querySelector('.main-header.navbar');
            if (window.scrollY > 50) {
                header.classList.add('scrolled');
            } else {
                header.classList.remove('scrolled');
            }
        });
    </script>

    @stack('js')
</body>
</html>