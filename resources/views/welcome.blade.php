<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <title>Barbería Elite - Inicio</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&family=Oswald:wght@400;500;600;700&display=swap" rel="stylesheet" />
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

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background-color: var(--color-blanco);
            font-family: 'Roboto', sans-serif;
            color: var(--color-gris-oscuro);
            min-height: 100vh;
            line-height: 1.6;
        }

        /* Header fijo con fondo beige */
        header {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 40px;
            background: linear-gradient(135deg, var(--color-beige) 0%, var(--color-beige-oscuro) 100%);
            z-index: 1000;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            border-bottom: 2px solid var(--color-dorado);
        }

        .logo-container img {
            max-width: 160px;
            max-height: 130px;
            filter: drop-shadow(0 0 8px rgba(16, 16, 16, 0.9));
            transition: filter 0.3s ease;
        }



        .nav-buttons {
            display: flex;
            gap: 15px;
        }

        /* Botones cuadrados */
        .nav-buttons a {
            padding: 12px 25px;
            background: linear-gradient(135deg, var(--color-dorado) 0%, var(--color-dorado-claro) 100%);
            color: var(--color-negro);
            text-decoration: none;
            font-weight: 700;
            border-radius: 8px; /* Bordes cuadrados */
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(212, 175, 55, 0.3);
            border: 2px solid transparent;
        }

        .nav-buttons a:hover {
            background: var(--color-negro);
            color: var(--color-dorado);
            border-color: var(--color-dorado);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(212, 175, 55, 0.4);
        }

        /* Contenedor principal */
        .container {
            padding-top: 180px;
            text-align: center;
            background: linear-gradient(135deg, var(--color-beige) 0%, var(--color-blanco) 100%);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        h1 {
            color: var(--color-gris-oscuro);
            margin-bottom: 30px;
            font-family: 'Oswald', sans-serif;
            font-weight: 700;
            font-size: 3.5rem;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1);
            background: linear-gradient(135deg, var(--color-gris-oscuro) 0%, var(--color-dorado) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .buttons {
            margin: 40px 0;
            display: flex;
            gap: 25px;
            flex-wrap: wrap;
            justify-content: center;
        }

        .buttons a {
            padding: 15px 35px;
            background: linear-gradient(135deg, var(--color-dorado) 0%, var(--color-dorado-claro) 100%);
            color: var(--color-negro);
            text-decoration: none;
            font-weight: 700;
            font-size: 1.1rem;
            border-radius: 30px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(212, 175, 55, 0.3);
            border: 2px solid transparent;
        }

        .buttons a:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(212, 175, 55, 0.4);
            border-color: var(--color-negro);
        }

        /* Sección de Servicios */
        #servicios {
            padding: 100px 20px;
            background: linear-gradient(135deg, var(--color-blanco) 0%, var(--color-beige) 100%);
            text-align: center;
        }

        #servicios h2 {
            font-size: 2.8rem;
            margin-bottom: 60px;
            color: var(--color-gris-oscuro);
            font-family: 'Oswald', sans-serif;
            font-weight: 600;
        }

        .cards {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 30px;
            max-width: 1200px;
            margin: 0 auto;
        }

        .card {
            background: linear-gradient(135deg, var(--color-blanco) 0%, var(--color-beige-oscuro) 100%);
            border-radius: 20px;
            width: 220px;
            padding: 35px 20px;
            color: var(--color-gris-oscuro);
            font-weight: 700;
            font-size: 1.1rem;
            text-align: center;
            display: flex;
            flex-direction: column;
            align-items: center;
            transition: all 0.4s ease;
            cursor: pointer;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
            border: 2px solid var(--color-dorado);
        }

        .card img {
            max-width: 80px;
            margin-bottom: 20px;
            transition: transform 0.4s ease;
            filter: drop-shadow(0 4px 8px rgba(0, 0, 0, 0.2));
        }

        .card:hover {
            transform: translateY(-10px) scale(1.05);
            background: linear-gradient(135deg, var(--color-dorado) 0%, var(--color-dorado-claro) 100%);
            box-shadow: 0 15px 40px rgba(212, 175, 55, 0.3);
        }

        .card:hover img {
            transform: scale(1.15);
        }

        /* Detalle de Servicios */
        .detalle-servicio {
            display: none;
            opacity: 0;
            transition: opacity 0.5s ease;
            padding: 80px 20px;
            background: linear-gradient(135deg, var(--color-negro) 0%, var(--color-gris-oscuro) 100%);
            text-align: center;
            color: var(--color-blanco);
        }

        .detalle-servicio.show {
            display: block;
            opacity: 1;
        }

        .btn-volver {
            margin-bottom: 40px;
            padding: 12px 25px;
            border: none;
            border-radius: 25px;
            background: linear-gradient(135deg, var(--color-dorado) 0%, var(--color-dorado-claro) 100%);
            color: var(--color-negro);
            cursor: pointer;
            font-weight: 700;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(212, 175, 55, 0.3);
        }

        .btn-volver:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(212, 175, 55, 0.4);
        }

        /* Sección de Descuentos */
        #descuentos {
            padding: 100px 20px;
            background: linear-gradient(135deg, var(--color-beige) 0%, var(--color-blanco) 100%);
            text-align: center;
        }

        #descuentos h2 {
            font-size: 2.8rem;
            margin-bottom: 60px;
            color: var(--color-gris-oscuro);
            font-family: 'Oswald', sans-serif;
            font-weight: 600;
        }

        .discount-cards {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 30px;
            max-width: 1200px;
            margin: 0 auto;
        }

        .discount-card {
            position: relative;
            background: linear-gradient(135deg, var(--color-blanco) 0%, var(--color-beige-oscuro) 100%);
            border-radius: 20px;
            width: 240px;
            padding: 25px;
            color: var(--color-gris-oscuro);
            font-weight: 700;
            text-align: center;
            transition: all 0.4s ease;
            cursor: pointer;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
            border: 2px solid var(--color-dorado);
            animation: flipIn 0.8s ease forwards;
        }

        .discount-card:hover {
            transform: translateY(-10px) scale(1.05);
            background: linear-gradient(135deg, var(--color-dorado) 0%, var(--color-dorado-claro) 100%);
            box-shadow: 0 15px 40px rgba(212, 175, 55, 0.3);
        }

        .discount-badge {
            position: absolute;
            top: 15px;
            right: 15px;
            background: linear-gradient(135deg, var(--color-gris-oscuro) 0%, var(--color-negro) 100%);
            color: var(--color-dorado);
            font-size: 1.1rem;
            font-weight: 700;
            padding: 8px 15px;
            border-radius: 25px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }

        .discount-card img {
            max-width: 140px;
            margin: 25px 0;
            transition: transform 0.4s ease;
            filter: drop-shadow(0 4px 8px rgba(0, 0, 0, 0.2));
        }

        .discount-card:hover img {
            transform: scale(1.15);
        }

        .product-name {
            display: block;
            margin-top: 15px;
            font-size: 1.3rem;
            color: var(--color-gris-oscuro);
        }

        /* Animaciones */
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
            0%, 100% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(-10px);
            }
        }

        .discount-card:nth-child(1) { animation-delay: 0.1s; }
        .discount-card:nth-child(2) { animation-delay: 0.3s; }
        .discount-card:nth-child(3) { animation-delay: 0.5s; }

        .discount-card:hover {
            animation: bounceHover 0.5s;
        }

        /* Testimonios - Nuevo diseño */
        #testimonios {
            padding: 100px 20px;
            background: linear-gradient(135deg, var(--color-negro) 0%, var(--color-gris-oscuro) 100%);
            text-align: center;
            color: var(--color-blanco);
        }

        #testimonios h2 {
            margin-bottom: 60px;
            font-size: 2.8rem;
            color: var(--color-dorado);
            font-family: 'Oswald', sans-serif;
            font-weight: 600;
        }

        .testimonios-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
            max-width: 1200px;
            margin: 0 auto;
        }

        .testimonio-card {
            background: linear-gradient(135deg, var(--color-gris-oscuro) 0%, var(--color-gris-medio) 100%);
            border-radius: 15px;
            padding: 30px;
            text-align: left;
            transition: all 0.3s ease;
            border-left: 4px solid var(--color-dorado);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3);
        }

        .testimonio-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 30px rgba(212, 175, 55, 0.2);
            border-left: 4px solid var(--color-dorado-claro);
        }

        .testimonio-text {
            font-size: 1rem;
            line-height: 1.6;
            margin-bottom: 20px;
            color: var(--color-beige);
            font-style: italic;
        }

        .testimonio-author {
            font-weight: 700;
            color: var(--color-dorado);
            font-size: 1.1rem;
        }

        .testimonio-rating {
            color: var(--color-dorado);
            margin-top: 10px;
            font-size: 1.2rem;
        }

        /* Footer compacto */
        footer {
            background: var(--color-negro);
            padding: 30px 20px;
            color: var(--color-blanco);
        }

        .footer-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 20px;
            max-width: 1200px;
            margin: 0 auto;
        }

        .footer-section {
            flex: 1;
            min-width: 250px;
        }

        .footer-title {
            color: var(--color-dorado);
            font-size: 1.2rem;
            margin-bottom: 15px;
            font-weight: 700;
            font-family: 'Oswald', sans-serif;
        }

        .redes-footer {
            display: flex;
            gap: 15px;
            justify-content: center;
        }

        .redes-footer a {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, var(--color-dorado) 0%, var(--color-dorado-claro) 100%);
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .redes-footer a:hover {
            transform: translateY(-3px) scale(1.1);
            background: var(--color-blanco);
        }

        .redes-footer a svg {
            width: 20px;
            height: 20px;
        }

        .direccion-footer {
            text-align: center;
        }

        .direccion-footer p {
            color: var(--color-beige);
            margin-bottom: 10px;
            font-size: 0.9rem;
        }

        .direccion-link {
            color: var(--color-dorado);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: color 0.3s ease;
        }

        .direccion-link:hover {
            color: var(--color-dorado-claro);
        }

        .copyright-footer {
            text-align: center;
            color: var(--color-beige);
            font-size: 0.8rem;
            margin-top: 20px;
            width: 100%;
        }

        /* Responsive */
        @media (max-width: 768px) {
            header {
                padding: 15px 20px;
                flex-direction: column;
                gap: 15px;
            }

            .container {
                padding-top: 220px;
            }

            h1 {
                font-size: 2.5rem;
            }

            .buttons {
                flex-direction: column;
                align-items: center;
            }

            .buttons a {
                width: 250px;
            }

            .cards, .discount-cards {
                flex-direction: column;
                align-items: center;
            }

            .card, .discount-card {
                width: 280px;
            }

            .testimonios-grid {
                grid-template-columns: 1fr;
            }

            .footer-content {
                flex-direction: column;
                text-align: center;
                gap: 25px;
            }

            .redes-footer {
                justify-content: center;
            }
        }

        @media (max-width: 480px) {
            h1 {
                font-size: 2rem;
            }

            .nav-buttons {
                flex-direction: column;
                width: 100%;
            }

            .nav-buttons a {
                text-align: center;
                width: 200px;
            }

            .card, .discount-card {
                width: 100%;
                max-width: 280px;
            }
        }
    </style>
</head>

<body>
    <!-- Header con fondo beige -->
    <header>
        <div class="logo-container">
            <img src="{{ asset('imagenes/servicios/logoStars.png') }}" alt="Logo Barbería Elite" />
        </div>
        <div class="nav-buttons">
            <a href="{{ route('login') }}">Iniciar Sesión</a>
            <a href="{{ route('register') }}">Registrarse</a>
        </div>
    </header>

    <!-- Contenedor principal -->
    <div class="container">
        <h1>Bienvenido a Stars BarbeShop</h1>
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

    <!-- Detalle de Servicios -->
    <section id="detalle-servicio" class="detalle-servicio">
        <button id="cerrar-detalle" class="btn-volver">← Volver a Servicios</button>
        <div id="contenido-detalle"></div>
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

    <!-- Sección de Testimonios - Nuevo diseño -->
    <section id="testimonios">
        <h2>Lo que dicen nuestros clientes</h2>
        <div class="testimonios-grid">
            <div class="testimonio-card">
                <div class="testimonio-text">
                    "Excelente atención y cortes perfectos. Siempre salgo satisfecho con el servicio y la profesionalidad del equipo."
                </div>
                <div class="testimonio-author">Rck Oz Melodian</div>
                <div class="testimonio-rating">★★★★★</div>
            </div>
            <div class="testimonio-card">
                <div class="testimonio-text">
                    "Siempre salgo satisfecho con mi barba. Los barberos son verdaderos artistas y conocen exactamente lo que necesito."
                </div>
                <div class="testimonio-author">Xana Lavey Princess</div>
                <div class="testimonio-rating">★★★★★</div>
            </div>

            <div class="testimonio-card">
                <div class="testimonio-text">
                    "Ambiente agradable y profesionales de primera. Llevo años siendo cliente y nunca me han defraudado."
                </div>
                <div class="testimonio-author">Esteban Dido</div>
                <div class="testimonio-rating">★★★★★</div>
            </div>
        </div>
    </section>

    <!-- Footer compacto -->
    <footer>
        <div class="footer-content">
            <div class="footer-section">
                <div class="footer-title">Síguenos</div>
                <div class="redes-footer">
                    <a href="https://www.facebook.com/StarsBarberShopOficial/?locale=es_LA" target="_blank" aria-label="Facebook" rel="noopener noreferrer">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48">
                            <path fill="#1877F3" d="M24 4C12.95 4 4 12.95 4 24c0 9.95 7.16 18.16 16.5 19.74V30.89h-4.97v-6.89h4.97v-5.25c0-4.92 2.93-7.64 7.42-7.64 2.15 0 4.4.38 4.4.38v4.83h-2.48c-2.44 0-3.2 1.52-3.2 3.08v3.6h5.44l-.87 6.89h-4.57v12.85C36.84 42.16 44 33.95 44 24c0-11.05-8.95-20-20-20z" />
                            <path fill="#fff" d="M30.43 37.74V30.89h4.57l.87-6.89h-5.44v-3.6c0-1.56.76-3.08 3.2-3.08h2.48v-4.83s-2.25-.38-4.4-.38c-4.49 0-7.42 2.72-7.42 7.64v5.25h-4.97v6.89h4.97v12.85c1.62.26 3.28.26 4.9 0z" />
                        </svg>
                    </a>
                    <a href="https://www.instagram.com/stars_barber_shop?igsh=ZHVjczZ6MGxwdmZz" target="_blank" aria-label="Instagram" rel="noopener noreferrer">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48">
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
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48">
                            <g>
                                <path fill="#25F4EE" d="M41.5,15.5c-3.6,0-6.5-2.9-6.5-6.5h-4.5v24.2c0,3.7-3,6.8-6.8,6.8c-3.7,0-6.8-3-6.8-6.8c0-3.7,3-6.8,6.8-6.8c0.4,0,0.8,0,1.2,0.1v-4.6c-0.4,0-0.8-0.1-1.2-0.1c-6.3,0-11.4,5.1-11.4,11.4c0,6.3,5.1,11.4,11.4,11.4c6.3,0,11.4-5.1,11.4-11.4V21.9c1.9,1.1,4.1,1.7,6.5,1.7V15.5z" />
                                <path fill="#FE2C55" d="M35,9v24.2c0,6.3-5.1,11.4-11.4,11.4c-6.3,0-11.4-5.1-11.4-11.4c0-6.3,5.1-11.4,11.4-11.4c0.4,0,0.8,0,1.2,0.1v4.6c-0.4,0-0.8-0.1-1.2-0.1c-3.7,0-6.8,3-6.8,6.8c0,3.7,3,6.8,6.8,6.8c3.7,0,6.8-3,6.8-6.8V9H35z" />
                                <path fill="#fff" d="M41.5,21.9c-2.4,0-4.6-0.6-6.5-1.7v-4.6c1.9,1.1,4.1,1.7,6.5,1.7V21.9z" />
                            </g>
                        </svg>
                    </a>
                </div>
            </div>

            <div class="footer-section direccion-footer">
                <div class="footer-title">Visítanos</div>
                <p>Av. Aniceto Padilla-Zona Recoleta Nº 579</p>
                <p>Cochabamba, Bolivia</p>
                <a href="https://www.google.com/maps" target="_blank" class="direccion-link" rel="noopener noreferrer">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="16" height="16">
                        <path fill="currentColor" d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5S10.62 6.5 12 6.5s2.5 1.12 2.5 2.5S13.38 11.5 12 11.5z" />
                    </svg>
                    Ver en Google Maps
                </a>
            </div>
        </div>
        <div class="copyright-footer">
            <p>© 2025 Barbería Elite. Todos los derechos reservados.</p>
        </div>
    </footer>

    <script>
        // Funcionalidad para los botones de navegación
        document.addEventListener('DOMContentLoaded', function() {
            const serviciosBtn = document.querySelector('a[href="#servicios"]');
            const testimoniosBtn = document.querySelector('a[href="#testimonios"]');
            
            serviciosBtn.addEventListener('click', function(e) {
                e.preventDefault();
                document.getElementById('servicios').scrollIntoView({ 
                    behavior: 'smooth',
                    block: 'start'
                });
            });
            
            testimoniosBtn.addEventListener('click', function(e) {
                e.preventDefault();
                document.getElementById('testimonios').scrollIntoView({ 
                    behavior: 'smooth',
                    block: 'start'
                });
            });

            // Funcionalidad de servicios
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

            servicios.forEach(card => {
                card.addEventListener('click', () => {
                    const servicio = card.querySelector('span').textContent;
                    const data = serviciosData[servicio];

                    let html = `<h2 style="color: var(--color-dorado); margin-bottom: 30px; font-size: 2.5rem;">${servicio}</h2>`;
                    html += `<p style="max-width:600px; margin:30px auto; font-size:1.2rem; line-height:1.6; color: var(--color-beige);">${data.descripcion}</p>`;
                    html += `<div style="display:flex; justify-content:center; gap:30px; flex-wrap:wrap; margin-top: 40px;">`;
                    data.imagenes.forEach(img => {
                        html += `<img src="${img}" style="width:250px; border-radius:15px; box-shadow: 0 8px 25px rgba(0,0,0,0.3);" />`;
                    });
                    html += `</div>`;

                    contenidoDetalle.innerHTML = html;

                    document.getElementById('servicios').style.opacity = '0';
                    setTimeout(() => document.getElementById('servicios').style.display = 'none', 500);

                    detalleSection.style.display = 'block';
                    setTimeout(() => detalleSection.classList.add('show'), 10);
                    
                    // Scroll al detalle
                    detalleSection.scrollIntoView({ behavior: 'smooth' });
                });
            });

            cerrarDetalle.addEventListener('click', () => {
                detalleSection.classList.remove('show');
                setTimeout(() => detalleSection.style.display = 'none', 500);

                const serviciosSec = document.getElementById('servicios');
                serviciosSec.style.display = 'block';
                setTimeout(() => serviciosSec.style.opacity = '1', 10);
                
                // Scroll de vuelta a servicios
                serviciosSec.scrollIntoView({ behavior: 'smooth' });
            });
        });
    </script>
</body>
</html>