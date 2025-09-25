<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <title>Inicio - Barbería</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet" />
    <style>
        body {
            margin: 0;
            padding: 0;
            background-color: #ffffff;
            /* Fondo blanco */
            font-family: 'Roboto', sans-serif;
            color: #222222;
            /* Texto gris oscuro */
            min-height: 100vh;
        }

        /* Header fijo con login/registro */
        header {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0px 2px;
            background-color: #f5f5f5;
            z-index: 1000;
        }


        .logo-container img {
            max-width: 190px;
            max-height: 160px;
            filter: drop-shadow(0 0 8px #444) drop-shadow(0 0 14px #555);
            transition: filter 0.3s ease;
        }

        .logo-container img:hover {
            filter: drop-shadow(0 0 14px #223344) drop-shadow(0 0 28px #334455);

        }

        
        .nav-buttons a {
            background: none !important;
            border: none !important;
            display: inline-block;
            margin-left: 15px;
            padding: 10px 25px;
            background: linear-gradient(135deg, #444444, #222222);
            /* plomo */
            color: #ffffff;
            text-decoration: none;
            font-weight: 700;
            border-radius: 25px;
            transition: 0.3s;
        }

        .nav-buttons a:hover {
            background: linear-gradient(135deg, #001933, #003366);
            /* azul super oscuro */
            transform: scale(1.05);
        }

        .container {
            padding-top: 160px;
            /* deja espacio para header */
            text-align: center;
        }

        h1 {
            color: #001933;
            margin-bottom: 20px;
            font-weight: 700;
            font-size: 3rem;
        }

        h1,
        h2,
        h3 {
            font-family: 'Oswald', sans-serif;
            color: #001933;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
            /* sombra suave */
        }



        .buttons {
            margin-bottom: 50px;
        }

        .buttons a {
            display: inline-block;
            margin: 10px 15px;
            padding: 14px 40px;
            background: linear-gradient(135deg, #444444, #222222);
            /* plomo */
            color: #ffffff;
            text-decoration: none;
            font-weight: 700;
            border-radius: 25px;
            box-shadow: 0 4px 10px rgba(68, 68, 68, 0.3);

            transition: background 0.3s ease, box-shadow 0.3s ease;
            font-size: 1.1rem;
            letter-spacing: 0.05em;
        }

        .buttons a:hover {
            background: linear-gradient(135deg, #001933, #003366);
            /* azul super oscuro */
            box-shadow: 0 6px 20px rgba(0, 25, 51, 0.4);

        }

        /* Sección de Servicios */
        #servicios {
            padding: 60px 20px;
            background-color: #fafafa;
            text-align: center;
        }

        #servicios h2 {
            font-size: 2.5rem;
            margin-bottom: 40px;
            color: #001933;
            /* azul super oscuro */
        }

        .cards {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
        }

        .card {
            background: linear-gradient(135deg, #444444, #222222);
            /* plomo */
            /* plomo */
            border-radius: 20px;
            width: 180px;
            padding: 30px 20px;
            color: #ffffff;
            font-weight: 700;
            font-size: 1.1rem;
            text-align: center;
            display: flex;
            flex-direction: column;
            align-items: center;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            cursor: pointer;
            box-shadow: 0 4px 10px rgba(68, 68, 68, 0.3);
        }

        .card img {
            max-width: 60px;
            margin-bottom: 15px;
            transition: transform 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
            background: linear-gradient(135deg, #001933, #003366);
            /* azul super oscuro */
            box-shadow: 0 6px 20px rgba(0, 25, 51, 0.4);
            /* azul super oscuro */
        }

        .card:hover img {
            transform: scale(1.1);
        }

        /* Detalle de servicio oculto inicialmente con fade */
        .detalle-servicio {
            display: none;
            opacity: 0;
            transition: opacity 0.5s ease, transform 0.5s ease;
            padding: 60px 20px;
            background-color: #ffffff;
            text-align: center;
        }

        .detalle-servicio.show {
            display: block;
            opacity: 1;
            transform: translateY(0);
        }

        .btn-volver {
            margin-bottom: 30px;
            padding: 10px 20px;
            border: none;
            border-radius: 10px;
            background: linear-gradient(135deg, #444444, #222222);
            color: #fff;
            cursor: pointer;
            font-weight: 700;
            transition: 0.3s;
        }

        .btn-volver:hover {
            transform: scale(1.05);
            background: linear-gradient(135deg, #001933, #003366);
        }



        /* Sección de Descuentos */
        #descuentos {
            padding: 60px 20px;
            background-color: #e4e3e3ff;
            text-align: center;
        }

        #descuentos h2 {
            font-size: 2.5rem;
            margin-bottom: 40px;
            color: #001933;
        }

        /* Cards de descuentos */
        .discount-cards {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
        }

        .discount-card {
            position: relative;
            background: linear-gradient(135deg, #878686ff, #ccbdbdff);
            /* plomo */
            border-radius: 20px;
            width: 200px;
            padding: 20px;
            color: #fff;
            font-weight: 700;
            text-align: center;
            transition: transform 0.3s, box-shadow 0.3s;
            cursor: pointer;
            box-shadow: 0 4px 10px rgba(68, 68, 68, 0.3);
        }

        .discount-card:hover {
            background: linear-gradient(135deg, #001933, #003366);
            /* azul super oscuro */

            transform: translateY(-10px) scale(1.05);
            box-shadow: 0 8px 25px rgba(0, 25, 51, 0.4);
        }

        /* Badge de porcentaje */
        .discount-badge {
            position: absolute;
            top: 10px;
            right: 10px;
            background-color: #001933;
            /* azul super oscuro */
            color: #fff;
            font-size: 1.1rem;
            font-weight: 700;
            padding: 5px 10px;
            border-radius: 50px;
            box-shadow: 0 0 10px rgba(255, 42, 42, 0.7);
        }

        /* Imagen del producto */
        .discount-card img {
            max-width: 120px;
            margin: 20px 0;
            transition: transform 0.3s;
        }

        .discount-card:hover img {
            transform: scale(1.1);
        }

        /* Nombre del producto */
        .discount-card .product-name {
            display: block;
            margin-top: 10px;
            font-size: 1.2rem;
        }

        /* Animaciones para los productos en descuento */
        @keyframes flipIn {
            0% {
                transform: rotateY(90deg) scale(0.8);
                opacity: 0;
            }

            50% {
                transform: rotateY(-10deg) scale(1.05);
                opacity: 1;
            }

            100% {
                transform: rotateY(0deg) scale(1);
                opacity: 1;
            }
        }

        @keyframes bounceHover {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-10px);
            }
        }

        /* Cards de descuentos con animación al cargar */
        .discount-card {
            position: relative;
            background: linear-gradient(135deg, #033c74ff, #017bb8ff);
            border-radius: 20px;
            width: 200px;
            padding: 20px;
            color: #fff;
            font-weight: 700;
            text-align: center;
            transition: transform 0.3s, box-shadow 0.3s;
            cursor: pointer;
            box-shadow: 0 4px 10px rgba(68, 68, 68, 0.3);
            animation: flipIn 0.8s ease forwards;
        }

        /* Delay entre cada card */
        .discount-card:nth-child(1) {
            animation-delay: 0.1s;
        }

        .discount-card:nth-child(2) {
            animation-delay: 0.3s;
        }

        .discount-card:nth-child(3) {
            animation-delay: 0.5s;
        }

        .discount-card:nth-child(4) {
            animation-delay: 0.7s;
        }

        /* Hover con rebote y efecto brillante */
        .discount-card:hover {
            animation: bounceHover 0.5s;
            transform: translateY(-10px) scale(1.05);
            box-shadow: 0 8px 25px rgba(0, 25, 51, 0.4);
        }

        /* Badge de porcentaje */
        .discount-badge {
            position: absolute;
            top: 10px;
            right: 10px;
            background-color: #ff2a2a;
            color: #fff;
            font-size: 1.1rem;
            font-weight: 700;
            padding: 5px 10px;
            border-radius: 50px;
            box-shadow: 0 0 10px rgba(255, 42, 42, 0.7);
        }

        /* Imagen del producto con efecto al pasar el mouse */
        .discount-card img {
            max-width: 120px;
            margin: 20px 0;
            transition: transform 0.3s;
        }

        .discount-card:hover img {
            transform: scale(1.1);
        }

        /* Nombre del producto */
        .discount-card .product-name {
            display: block;
            margin-top: 10px;
            font-size: 1.2rem;
        }


        /* Testimonios */
        #testimonios {
            background-color: #ffffff;
            padding: 60px 20px;
            text-align: center;
        }

        #testimonios h2 {
            margin-bottom: 40px;
            font-size: 2rem;
            color: #001933;
        }

        .testimonial-card {
            background-color: #f5f5f5;
            padding: 20px;
            margin: 15px;
            border-radius: 20px;
            width: 250px;
            display: inline-block;
            box-shadow: 0 0 10px rgba(68, 68, 68, 0.2);
            transition: transform 0.3s, box-shadow 0.3s;
            color: #222222;
        }

        .testimonial-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 0 20px rgba(0, 25, 51, 0.3);
        }



        /* Responsive */
        @media (max-width: 768px) {

            .cards,
            .testimonial-card {
                flex-direction: column;
                width: 90%;
            }

            header {
                flex-direction: column;
                gap: 15px;
            }

            .nav-buttons {
                margin-top: 10px;
            }

        }

        /* Slider Testimonios */
        .testimonial-slider {
            display: flex;
            overflow: hidden;
            width: 100%;
            justify-content: center;
            position: relative;
            height: 150px;
            /* altura fija del slider */
        }

        .testimonial-card {
            flex: 0 0 250px;
            margin: 0 15px;
            background-color: #f5f5f5;
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            box-shadow: 0 0 10px rgba(68, 68, 68, 0.2);
            transition: transform 0.3s, box-shadow 0.3s;
            color: #222222;

        }

        /* Animación automática con keyframes */
        @keyframes slide {
            0% {
                transform: translateX(0);
            }

            20% {
                transform: translateX(0);
            }

            25% {
                transform: translateX(-270px);
            }

            45% {
                transform: translateX(-270px);
            }

            50% {
                transform: translateX(-540px);
            }

            70% {
                transform: translateX(-540px);
            }

            75% {
                transform: translateX(-810px);
            }

            95% {
                transform: translateX(-810px);
            }

            100% {
                transform: translateX(0);
            }
        }

        .testimonial-slider {
            animation: slide 16s infinite;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .testimonial-slider {
                height: auto;
                flex-direction: column;
            }

            .testimonial-card {
                flex: none;
                width: 90%;
                margin: 10px auto;
            }
        }




        footer {
            background-color: #e0ddddff;
            padding: 30px 40px;
        }

        .footer-top {
            display: flex;
            justify-content: space-between;
            /* redes izquierda, copyright centro, dirección derecha */
            align-items: center;
            flex-wrap: wrap;
            gap: 20px;
        }

        .redes-footer a {
            font-size: 2rem;
            margin-right: 10px;
            color: #e9eff2ff;
            transition: color 0.3s ease;
        }


        .footer-top {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
        }


        .direccion-footer a svg {
            width: 32px;
            /* mismo tamaño para todos */
            height: 32px;
            fill: currentColor;
        }

        .redes-footer a svg {
            display: middle;
            width: 20px;
            height: 20px;
        }

        .redes-footer a:hover {
            color: #666;
        }

        .copyright-footer {
            color: #666;
            font-size: 0.9rem;
            text-align: center;
            flex: 1;
            /* para centrarlo */
        }

        .direccion-footer a {
            color: #202121ff;
            text-decoration: none;
            display: flex;
            align-items: center;
            font-size: 1rem;
        }

        .direccion-footer a svg {
            margin-right: 8px;
            fill: #00aaff;
        }

        .direccion-footer a:hover {
            color: #a5aeafff;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .footer-top {
                flex-direction: column;
                text-align: center;
                gap: 15px;
            }

            .redes-footer,
            .direccion-footer {
                justify-content: center;
            }
        }
    </style>
</head>

<body>
    <!-- Header con login/registro -->
    <header>
        <div class="logo-container">
            <img src="{{ asset('imagenes/servicios/logoStars.png') }}" alt="Logo Barbería" />
        </div>
        <div class="nav-buttons">
            <a href="{{ route('login') }}">Iniciar Sesión</a>
            <a href="{{ route('register') }}">Registrarse</a>
        </div>
    </header>

    <!-- Contenedor principal -->
    <div class="container">
        <h1>Bienvenido a nuestra Barbería</h1>

        <div class="buttons">
            <a href="#servicios">Nuestros Servicios</a>
            <a href="#testimonios">Testimonios</a>
        </div>
    </div>
    <!-- Sección de Servicios -->
    <section id="servicios">
        <h2>Nuestros Servicios</h2>
        <div class="cards">
            <div class="card">
                <img src="imagenes/servicios/icono-corte.png" alt="Corte Clásico" />
                <span>Corte Clásico</span>
            </div>
            <div class="card">
                <img src="imagenes/servicios/icono-barba.png" alt="Barba & Bigote" />
                <span>Barba & Bigote</span>
            </div>
            <div class="card">
                <img src="imagenes/servicios/icono-peinado.png" alt="Peinados Modernos" />
                <span>Peinados Modernos</span>
            </div>
            <div class="card">
                <img src="imagenes/servicios/icono-color.png" alt="Color y Estilo" />
                <span>Color y Estilo</span>
            </div>
        </div>
    </section>

    <!-- Detalle de Servicios (oculto inicialmente) -->
    <section id="detalle-servicio" class="detalle-servicio" style="display:none; padding: 60px 20px; background-color:#111111; text-align:center;">
        <button id="cerrar-detalle" class="btn-volver" style="margin-bottom:30px; padding:10px 20px; border:none; border-radius:10px; background:#00aaff; color:#fff; cursor:pointer;">← Volver a Servicios</button>
        <div id="contenido-detalle">
            <!-- Aquí se cargará dinámicamente el detalle según el servicio seleccionado -->
        </div>
    </section>




    <!-- Sección de Descuentos -->
    <section id="descuentos">
        <h2>Productos en Descuento</h2>
        <div class="discount-cards">
            <div class="discount-card">
                <div class="discount-badge">-20%</div>
                <img src="imagenes/descuentos/producto1.png" alt="Producto 1">
                <span class="product-name">Corte Premium</span>
            </div>
            <div class="discount-card">
                <div class="discount-badge">-30%</div>
                <img src="imagenes/descuentos/producto2.png" alt="Producto 2">
                <span class="product-name">Kit de Barba</span>
            </div>
            <div class="discount-card">
                <div class="discount-badge">-15%</div>
                <img src="imagenes/descuentos/producto3.png" alt="Producto 3">
                <span class="product-name">Peinado Especial</span>
            </div>
        </div>
    </section>


    <!-- Sección de Testimonios con Slider -->
    <section id="testimonios">
        <h2>Lo que dicen nuestros clientes</h2>
        <div class="testimonial-slider">
            <div class="testimonial-card">"Excelente atención y cortes perfectos." - Rck Oz Melodian</div>
            <div class="testimonial-card">"Siempre salgo satisfecho con mi barba." - Xana Lavey Princess</div>
            <div class="testimonial-card">"El mejor lugar para un cambio de look." - Aleyda Rodriguez</div>
            <div class="testimonial-card">"Ambiente agradable y profesionales." - Esteban Dido </div>
        </div>
    </section>

    <!-- Footer original con redes sociales -->

    <footer>
        <div class="footer-top">
            <div class="redes-footer">
                <a href="https://www.facebook.com/StarsBarberShopOficial/?locale=es_LA" target="_blank" aria-label="Facebook" rel="noopener noreferrer">
                    <!-- Facebook SVG Oficial -->
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48" style="width: 20px; height: 20px;">
                        <path fill="#1877F3" d="M24 4C12.95 4 4 12.95 4 24c0 9.95 7.16 18.16 16.5 19.74V30.89h-4.97v-6.89h4.97v-5.25c0-4.92 2.93-7.64 7.42-7.64 2.15 0 4.4.38 4.4.38v4.83h-2.48c-2.44 0-3.2 1.52-3.2 3.08v3.6h5.44l-.87 6.89h-4.57v12.85C36.84 42.16 44 33.95 44 24c0-11.05-8.95-20-20-20z" />
                        <path fill="#fff" d="M30.43 37.74V30.89h4.57l.87-6.89h-5.44v-3.6c0-1.56.76-3.08 3.2-3.08h2.48v-4.83s-2.25-.38-4.4-.38c-4.49 0-7.42 2.72-7.42 7.64v5.25h-4.97v6.89h4.97v12.85c1.62.26 3.28.26 4.9 0z" />
                    </svg>
                </a>
                <a href="https://www.instagram.com/stars_barber_shop?igsh=ZHVjczZ6MGxwdmZz" target="_blank" aria-label="Instagram" rel="noopener noreferrer">
                    <!-- Instagram SVG Oficial -->
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48" style="width: 20px; height: 20px;">
                        <radialGradient id="IG1" cx="19.38" cy="42.035" r="44.899" gradientUnits="userSpaceOnUse">
                            <stop offset="0" stop-color="#fd5" />
                            <stop offset=".5" stop-color="#ff543f" />
                            <stop offset="1" stop-color="#c837ab" />
                        </radialGradient>
                        <path fill="url(#IG1)" d="M34.5 4h-21C8.01 4 4 8.01 4 13.5v21C4 39.99 8.01 44 13.5 44h21c5.49 0 9.5-4.01 9.5-9.5v-21C44 8.01 39.99 4 34.5 4zM24 34.5c-5.8 0-10.5-4.7-10.5-10.5S18.2 13.5 24 13.5 34.5 18.2 34.5 24 29.8 34.5 24 34.5zm11.5-19.5c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2z" />
                        <circle fill="#fff" cx="24" cy="24" r="6.5" />
                    </svg>
                </a>
                <a href="https://www.tiktok.com/@stars.barber.shop" target="_blank" aria-label="TikTok" rel="noopener noreferrer">
                    <!-- TikTok SVG Oficial -->
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48">
                        <g>
                            <path fill="#25F4EE" d="M41.5,15.5c-3.6,0-6.5-2.9-6.5-6.5h-4.5v24.2c0,3.7-3,6.8-6.8,6.8c-3.7,0-6.8-3-6.8-6.8c0-3.7,3-6.8,6.8-6.8c0.4,0,0.8,0,1.2,0.1v-4.6c-0.4,0-0.8-0.1-1.2-0.1c-6.3,0-11.4,5.1-11.4,11.4c0,6.3,5.1,11.4,11.4,11.4c6.3,0,11.4-5.1,11.4-11.4V21.9c1.9,1.1,4.1,1.7,6.5,1.7V15.5z" />
                            <path fill="#FE2C55" d="M35,9v24.2c0,6.3-5.1,11.4-11.4,11.4c-6.3,0-11.4-5.1-11.4-11.4c0-6.3,5.1-11.4,11.4-11.4c0.4,0,0.8,0,1.2,0.1v4.6c-0.4,0-0.8-0.1-1.2-0.1c-3.7,0-6.8,3-6.8,6.8c0,3.7,3,6.8,6.8,6.8c3.7,0,6.8-3,6.8-6.8V9H35z" />
                            <path fill="#fff" d="M41.5,21.9c-2.4,0-4.6-0.6-6.5-1.7v-4.6c1.9,1.1,4.1,1.7,6.5,1.7V21.9z" />
                        </g>
                    </svg>
                </a>
                <a href="#" target="_blank" aria-label="WhatsApp" rel="noopener noreferrer">
                    <!-- WhatsApp SVG Oficial -->
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48">
                        <g>
                            <path fill="#25D366" d="M4,42l2.9-10.6C5.2,28.1,4.5,25.6,4.5,23C4.5,12.8,13.3,4,23.5,4c5.1,0,9.9,2,13.5,5.6c3.6,3.6,5.6,8.4,5.6,13.5c0,10.2-8.8,19-19,19c-2.5,0-5-0.5-7.3-1.5L4,42z" />
                            <path fill="#FFF" d="M20.1,15.6c-0.4-0.9-0.8-0.9-1.2-0.9c-0.3,0-0.7,0-1.1,0c-0.4,0-1,0.1-1.5,0.7c-0.5,0.6-2,2-2,4.8c0,2.8,2,5.5,2.3,5.9c0.3,0.4,3.9,6.2,9.5,8.2c1.3,0.4,2.3,0.7,3.1,0.9c1.3,0.3,2.5,0.3,3.4,0.2c1-0.1,3-1.2,3.4-2.4c0.4-1.2,0.4-2.2,0.3-2.4c-0.1-0.2-0.3-0.3-0.6-0.5c-0.3-0.2-1.7-0.8-2-0.9c-0.3-0.1-0.5-0.2-0.7,0.2c-0.2,0.3-0.8,1-1,1.2c-0.2,0.2-0.4,0.2-0.7,0.1c-0.3-0.1-1.4-0.5-2.7-1.6c-1-0.9-1.7-2-1.9-2.3c-0.2-0.3,0-0.5,0.1-0.7c0.1-0.1,0.3-0.4,0.5-0.6c0.2-0.2,0.2-0.4,0.3-0.6c0.1-0.2,0-0.4-0.1-0.6c-0.1-0.2-0.8-2-1.1-2.7C20.6,16.7,20.5,16.5,20.1,15.6z" />
                        </g>
                    </svg>
                </a>

                <a href="#" target="_blank" aria-label="YouTube" rel="noopener noreferrer">
                    <!-- YouTube SVG Oficial -->
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48" style="width: 20px; height: 20px;">
                        <path fill="#FF0000" d="M44.5,13.5c-0.5-2-2-3.5-4-4c-3.5-1-17.5-1-17.5-1s-14,0-17.5,1c-2,0.5-3.5,2-4,4c-1,3.5-1,10.5-1,10.5s0,7,1,10.5c0.5,2,2,3.5,4,4c3.5,1,17.5,1,17.5,1s14,0,17.5-1c2-0.5,3.5-2,4-4c1-3.5,1-10.5,1-10.5S45.5,17,44.5,13.5z" />
                        <polygon fill="#fff" points="19,31 31,24 19,17" />
                    </svg>
                </a>

            </div>

            <div class="copyright-footer">
                <p>© 2025 Rck Oz-Stars Barber Shop. Todos los derechos reservados.</p>
            </div>

            <div class="direccion-footer">
                <a href="https://www.google.com/maps/place/STARS+Barber+Shop,+C.+A.+Padilla+575,+Cochabamba/data=!4m2!3m1!1s0x93e375ac90d99b0b:0x6f92e546d552200f?utm_source=mstt_1&entry=gps&coh=192189&g_ep=CAESBjI1LjQuMRgAIJ6dCip1LDk0MjU1NDUwLDk0MjQyNTE0LDk0MjIzMjk5LDk0MjE2NDEzLDk0MjEyNDk2LDk0MjA3Mzk0LDk0MjA3NTA2LDk0MjA4NTA2LDk0MjE3NTIzLDk0MjE4NjUzLDk0MjI5ODM5LDQ3MDg0MzkzLDk0MjEzMjAwQgJCTw%3D%3D&skid=fb99055f-1756-4e8e-b50c-78a3c5072f5a" target="_blank" aria-label="Ubicación en Google Maps" rel="noopener noreferrer">
                    <!-- Icono de ubicación SVG -->
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" style="margin-right: 8px;">
                        <path fill="#00aaff" d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5S10.62 6.5 12 6.5s2.5 1.12 2.5 2.5S13.38 11.5 12 11.5z" />
                    </svg>
                    Av. Aniceto Padilla-Zona Recoleta Nº 579, Cochabamba, Bolivia
                </a>
            </div>
        </div>
    </footer>
    <!-- JavaScript para interactividad -->

    <script>
        const servicios = document.querySelectorAll('.card');
        const detalleSection = document.getElementById('detalle-servicio');
        const contenidoDetalle = document.getElementById('contenido-detalle');
        const cerrarDetalle = document.getElementById('cerrar-detalle');

        const serviciosData = {
            "Corte Clásico": {
                descripcion: "Un corte tradicional y elegante, ideal para mantener un estilo clásico y profesional.",
                imagenes: ["imagenes/servicios/detalle-corte1.png", "imagenes/servicios/detalle-corte2.png"]
            },
            "Barba & Bigote": {
                descripcion: "Damos forma, recortamos y estilizamos tu barba y bigote con productos de alta calidad.",
                imagenes: ["imagenes/servicios/detalle-barba1.png", "imagenes/servicios/detalle-barba2.png"]
            },
            "Peinados Modernos": {
                descripcion: "Peinados creativos y modernos adaptados a tu estilo y personalidad.",
                imagenes: ["imagenes/servicios/detalle-peinado1.png", "imagenes/servicios/detalle-peinado2.png"]
            },
            "Color y Estilo": {
                descripcion: "Aplicación de color, mechas y tratamientos para un look renovado y profesional.",
                imagenes: ["imagenes/servicios/detalle-color1.png", "imagenes/servicios/detalle-color2.png"]
            }
        };

        // Mostrar detalle con animación
        servicios.forEach(card => {
            card.addEventListener('click', () => {
                const servicio = card.querySelector('span').textContent;
                const data = serviciosData[servicio];

                let html = `<h2>${servicio}</h2>`;
                html += `<p style="max-width:600px; margin:20px auto; font-size:1.1rem; line-height:1.5;">${data.descripcion}</p>`;
                html += `<div style="display:flex; justify-content:center; gap:20px; flex-wrap:wrap;">`;
                data.imagenes.forEach(img => {
                    html += `<img src="${img}" style="width:200px; border-radius:15px;" />`;
                });
                html += `</div>`;

                contenidoDetalle.innerHTML = html;

                // Ocultar servicios y mostrar detalle con efecto
                document.getElementById('servicios').style.opacity = '0';
                setTimeout(() => document.getElementById('servicios').style.display = 'none', 500);

                detalleSection.style.display = 'block';
                setTimeout(() => detalleSection.classList.add('show'), 10); // pequeña espera para animación
            });
        });

        // Botón volver con animación
        cerrarDetalle.addEventListener('click', () => {
            detalleSection.classList.remove('show');
            setTimeout(() => detalleSection.style.display = 'none', 500);

            const serviciosSec = document.getElementById('servicios');
            serviciosSec.style.display = 'block';
            setTimeout(() => serviciosSec.style.opacity = '1', 10);
        });
    </script>


</body>

</html>