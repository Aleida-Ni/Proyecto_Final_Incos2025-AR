<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Barbería Elite - Cliente')</title>

    <!-- AdminLTE + FontAwesome + Bootstrap 5 -->
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/dist/css/adminlte.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        :root {
            --color-blanco: #FFFFFF;
            --color-negro: #000000;
            --color-dorado: #D4AF37;
            --color-dorado-claro: #F4E4A8;
            --color-beige: #F5F5DC;
            --color-beige-oscuro: #E8E4D5;
            --color-gris-oscuro: #2C2C2C;
            --color-gris-medio: #4A4A4A;
        }

        body {
            background-color: var(--color-blanco) !important;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .content-wrapper { 
            background-color: transparent !important; 
        }

        /* HEADER - ESTADO INICIAL (ELEGANTE) */
        .main-header.navbar {
            background: linear-gradient(135deg, var(--color-blanco) 0%, var(--color-beige) 100%) !important;
            border-bottom: 3px solid var(--color-dorado) !important;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1) !important;
            flex-direction: column;
            align-items: center;
            padding: 25px 0;
            transition: all 0.4s ease;
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 1000;
        }

        /* Header cuando hace scroll (NEGRO ELEGANTE) */
        .main-header.navbar.scrolled {
            background: linear-gradient(135deg, var(--color-negro) 0%, var(--color-gris-oscuro) 100%) !important;
            padding: 15px 0;
            border-bottom: 3px solid var(--color-dorado) !important;
        }

        .navbar-brand img {
            max-height: 100px;
            transition: all 0.4s ease;
            filter: drop-shadow(0 2px 8px rgba(0,0,0,0.2));
        }

        .main-header.navbar.scrolled .navbar-brand img {
            max-height: 70px;
            filter: drop-shadow(0 2px 12px rgba(212, 175, 55, 0.3));
        }

        /* Logo con efecto dorado */
        .logo-sparkle { 
            position: relative; 
            display: inline-block; 
        }
        .logo-sparkle img { 
            display: block;     
            transition: all 0.4s ease;
        }
        
        .logo-sparkle .sparkles {
            position: absolute;
            inset: 0;
            pointer-events: none;
            border-radius: 8px;
            mix-blend-mode: multiply;
            background-image: 
                radial-gradient(2px 2px at 20% 30%, rgba(212, 175, 55, 0.6), rgba(212, 175, 55, 0)),
                radial-gradient(1.8px 1.8px at 70% 50%, rgba(244, 228, 168, 0.5), rgba(244, 228, 168, 0)),
                radial-gradient(1.6px 1.6px at 40% 70%, rgba(212, 175, 55, 0.4), rgba(212, 175, 55, 0));
            opacity: 0.8;
            animation: sparkle-gold 3.5s ease-in-out infinite;
        }

        .main-header.navbar.scrolled .logo-sparkle .sparkles {
            mix-blend-mode: screen;
            background-image: 
                radial-gradient(2px 2px at 20% 30%, rgba(212, 175, 55, 0.9), rgba(212, 175, 55, 0)),
                radial-gradient(1.8px 1.8px at 70% 50%, rgba(244, 228, 168, 0.8), rgba(244, 228, 168, 0)),
                radial-gradient(1.6px 1.6px at 40% 70%, rgba(212, 175, 55, 0.7), rgba(212, 175, 55, 0));
            opacity: 0.9;
        }

        @keyframes sparkle-gold {
            0%, 100% { 
                opacity: 0.6; 
                transform: scale(1) rotate(0deg);
            }
            50% { 
                opacity: 1; 
                transform: scale(1.05) rotate(180deg);
            }
        }

        /* Navegación */
        .navbar-nav .nav-link {
            color: var(--color-gris-oscuro) !important;
            font-weight: 600;
            margin: 0 20px;
            transition: all 0.3s ease;
            position: relative;
            font-size: 1rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .main-header.navbar.scrolled .navbar-nav .nav-link {
            color: var(--color-blanco) !important;
        }

        .navbar-nav .nav-link:hover {
            color: var(--color-dorado) !important;
            transform: translateY(-2px);
        }

        .navbar-nav .nav-link::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 0;
            height: 2px;
            background: linear-gradient(90deg, var(--color-dorado), var(--color-dorado-claro));
            transition: width 0.3s ease;
        }

        .navbar-nav .nav-link:hover::after {
            width: 100%;
        }

        /* Dropdown elegante */
        .dropdown-menu {
            background: linear-gradient(135deg, var(--color-negro) 0%, var(--color-gris-oscuro) 100%);
            border: 1px solid var(--color-dorado);
            border-radius: 8px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.3);
        }
        
        .dropdown-item {
            color: var(--color-blanco);
            font-weight: 500;
            padding: 10px 20px;
            transition: all 0.3s ease;
        }
        
        .dropdown-item:hover {
            background: linear-gradient(135deg, var(--color-dorado) 0%, var(--color-dorado-claro) 100%);
            color: var(--color-negro);
            transform: translateX(5px);
        }

        /* Ajuste del contenido para el header fijo */
        .content-wrapper {
            margin-top: 200px;
            transition: margin-top 0.4s ease;
        }

        .main-header.navbar.scrolled ~ .content-wrapper {
            margin-top: 140px;
        }

        /* FOOTER ELEGANTE */
        .main-footer {
            background: linear-gradient(135deg, var(--color-negro) 0%, var(--color-gris-oscuro) 100%);
            color: var(--color-blanco);
            padding: 40px 0 20px;
            border-top: 3px solid var(--color-dorado);
            margin-top: 60px;
        }

        .footer-logo img {
            max-height: 80px;
            filter: drop-shadow(0 2px 8px rgba(212, 175, 55, 0.4));
        }

        .footer-links a {
            color: var(--color-blanco);
            margin: 0 20px;
            text-decoration: none;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
        }

        .footer-links a:hover {
            color: var(--color-dorado) !important;
            transform: translateY(-2px);
        }

        .footer-social a {
            color: var(--color-blanco);
            margin: 0 15px;
            font-size: 1.4rem;
            transition: all 0.3s ease;
        }

        .footer-social a:hover {
            color: var(--color-dorado) !important;
            transform: scale(1.2);
        }

        .main-footer small {
            color: var(--color-beige);
            font-weight: 500;
        }

        /* Botón de dropdown personalizado */
        #userDropdown {
            background: linear-gradient(135deg, var(--color-dorado) 0%, var(--color-dorado-claro) 100%);
            color: var(--color-negro) !important;
            border-radius: 25px;
            padding: 8px 20px;
            font-weight: 600;
            border: 2px solid transparent;
            transition: all 0.3s ease;
        }

        #userDropdown:hover {
            background: linear-gradient(135deg, var(--color-dorado-claro) 0%, var(--color-dorado) 100%);
            border-color: var(--color-negro);
            transform: translateY(-2px);
        }
    </style>

    @stack('css')
</head>
<body class="hold-transition layout-top-nav">
    <div class="wrapper">

        <!-- HEADER ELEGANTE -->
        <nav class="main-header navbar navbar-expand-md">
            <div class="container flex-column text-center">
                <!-- LOGO CON EFECTO DORADO -->
                <a href="{{ route('cliente.inicio') }}" class="navbar-brand mx-auto mb-3">
                    <span class="logo-sparkle">
                        <img src="{{ asset('storage/imagenes/logoStars.png') }}" alt="Barbería Elite">
                        <span class="sparkles" aria-hidden="true"></span>
                    </span>
                </a>

                <!-- MENÚ ELEGANTE -->
                <div class="collapse navbar-collapse show" id="navbarCollapse">
                    <ul class="navbar-nav mx-auto">
                        <li class="nav-item">
                            <a href="{{ route('cliente.inicio') }}" class="nav-link">
                                <i class="fas fa-home mr-2"></i>INICIO
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('cliente.barberos.index') }}" class="nav-link">
                                <i class="fas fa-calendar-check mr-2"></i>RESERVA TU CITA
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('cliente.productos.index') }}" class="nav-link">
                                <i class="fas fa-shopping-bag mr-2"></i>TIENDA
                            </a>
                        </li>

                        @auth
                        <li class="nav-item dropdown">
                            <a id="userDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                               data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-user-circle mr-2"></i>{{ Auth::user()->nombre }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        <i class="fas fa-sign-out-alt mr-2"></i>Cerrar sesión
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

        <!-- CONTENIDO PRINCIPAL -->
        <div class="content-wrapper">
            <div class="content">
                @yield('content')
            </div>
        </div>

        <!-- FOOTER ELEGANTE -->
        <footer class="main-footer text-center">
            <div class="container">
                <!-- LOGO FOOTER -->
                <div class="footer-logo mb-4">
                    <span class="logo-sparkle">
                        <img src="{{ asset('storage/imagenes/logoStars.png') }}" alt="Barbería Elite">
                        <span class="sparkles" aria-hidden="true"></span>
                    </span>
                </div>

                <!-- ENLACES FOOTER -->
                <div class="footer-links mb-4">
                    <a href="{{ route('cliente.inicio') }}">INICIO</a>
                    <a href="{{ route('cliente.barberos.index') }}">BARBEROS</a>
                    <a href="{{ route('cliente.productos.index') }}">TIENDA</a>
                </div>

                <!-- REDES SOCIALES -->
                <div class="footer-social mb-4">
                    <a href="#"><i class="fab fa-facebook"></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                    <a href="#"><i class="fab fa-whatsapp"></i></a>
                    <a href="#"><i class="fab fa-tiktok"></i></a>
                </div>

                <!-- COPYRIGHT -->
                <small>
                    <i class="fas fa-copyright mr-2"></i>
                    {{ date('Y') }} Barbería Elite. Todos los derechos reservados.
                </small>
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
            if (window.scrollY > 80) {
                header.classList.add('scrolled');
            } else {
                header.classList.remove('scrolled');
            }
        });

        // Smooth scroll para enlaces internos
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
    </script>

    @stack('js')
</body>
</html>