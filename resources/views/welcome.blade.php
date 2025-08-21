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
            background-color: #000000;
            font-family: 'Roboto', sans-serif;
            color: #ffffff;
            text-align: center;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .container {
            padding-top: 40px; /* menos espacio arriba */
            flex-grow: 1;
        }

        .logo-container {
            margin-bottom: 30px;
        }

        .logo-container img {
            max-width: 190px; /* más grande */
            max-height: 160px;
            filter:
                drop-shadow(0 0 8px #00aaff)
                drop-shadow(0 0 14px #0077cc)
                drop-shadow(0 0 28px #00ccff);
            transition: filter 0.3s ease;
        }
        .logo-container img:hover {
            filter:
                drop-shadow(0 0 14px #00c0ff)
                drop-shadow(0 0 28px #0099ee)
                drop-shadow(0 0 40px #00e5ff);
        }

        h1 {
            font-size: 2.5rem;
            margin-bottom: 20px;
        }

        .buttons a {
            display: inline-block;
            margin: 10px 15px;
            padding: 14px 40px;
            background: linear-gradient(135deg, #00aaff, #004488);
            color: #ffffff;
            text-decoration: none;
            font-weight: 700;
            border-radius: 25px;
            box-shadow:
                0 4px 10px rgba(0, 170, 255, 0.6),
                0 0 15px rgba(0, 170, 255, 0.5);
            transition: background 0.3s ease, box-shadow 0.3s ease;
            font-size: 1.1rem;
            letter-spacing: 0.05em;
        }

        .buttons a:hover {
            background: linear-gradient(135deg, #005f99, #002244);
            box-shadow:
                0 6px 20px rgba(0, 255, 255, 0.9),
                0 0 25px rgba(0, 255, 255, 0.7);
        }

        footer {
            padding: 30px 40px;
            background-color: #111111;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 10px;
        }

        .footer-icons {
            display: flex;
            justify-content: center;
            gap: 30px;
        }

        footer a {
            color: #00aaff;
            text-decoration: none;
            font-size: 2.8rem;
            transition: color 0.3s ease;
            display: flex;
            align-items: center;
        }

        footer a:hover {
            color: #00e5ff;
        }

        /* SVG icons color fill */
        footer svg {
            fill: currentColor;
            width: 20px;
            height: 20px;
        }

        .footer-nav {
            margin-top: 10px;
            color: #aaa;
            font-size: 1em;
            text-align: center;
        }

        .footer-nav span {
            margin: 0 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="logo-container">
            <img src="{{ asset('storage/imagenes/logoStars.png') }}" alt="Logo Barbería" />
        </div>

        <h1>Bienvenido a nuestra Barbería</h1>

        <div class="buttons">
            <a href="{{ route('login') }}">Iniciar Sesión</a>
            <a href="{{ route('register') }}">Registrarse</a>
        </div>
    </div>

    <footer>
        <div class="footer-icons">
            <a href="https://www.facebook.com/tuBarberia" target="_blank" aria-label="Facebook" rel="noopener noreferrer">
                <!-- Facebook SVG Oficial -->
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48" style="width: 20px; height: 20px;">
                    <path fill="#1877F3" d="M24 4C12.95 4 4 12.95 4 24c0 9.95 7.16 18.16 16.5 19.74V30.89h-4.97v-6.89h4.97v-5.25c0-4.92 2.93-7.64 7.42-7.64 2.15 0 4.4.38 4.4.38v4.83h-2.48c-2.44 0-3.2 1.52-3.2 3.08v3.6h5.44l-.87 6.89h-4.57v12.85C36.84 42.16 44 33.95 44 24c0-11.05-8.95-20-20-20z"/>
                    <path fill="#fff" d="M30.43 37.74V30.89h4.57l.87-6.89h-5.44v-3.6c0-1.56.76-3.08 3.2-3.08h2.48v-4.83s-2.25-.38-4.4-.38c-4.49 0-7.42 2.72-7.42 7.64v5.25h-4.97v6.89h4.97v12.85c1.62.26 3.28.26 4.9 0z"/>
                </svg>
            </a>
            <a href="https://www.instagram.com/tuBarberia" target="_blank" aria-label="Instagram" rel="noopener noreferrer">
                <!-- Instagram SVG Oficial -->
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48" style="width: 20px; height: 20px;">
                    <radialGradient id="IG1" cx="19.38" cy="42.035" r="44.899" gradientUnits="userSpaceOnUse">
                        <stop offset="0" stop-color="#fd5"/>
                        <stop offset=".5" stop-color="#ff543f"/>
                        <stop offset="1" stop-color="#c837ab"/>
                    </radialGradient>
                    <path fill="url(#IG1)" d="M34.5 4h-21C8.01 4 4 8.01 4 13.5v21C4 39.99 8.01 44 13.5 44h21c5.49 0 9.5-4.01 9.5-9.5v-21C44 8.01 39.99 4 34.5 4zM24 34.5c-5.8 0-10.5-4.7-10.5-10.5S18.2 13.5 24 13.5 34.5 18.2 34.5 24 29.8 34.5 24 34.5zm11.5-19.5c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2z"/>
                    <circle fill="#fff" cx="24" cy="24" r="6.5"/>
                </svg>
            </a>
            <a href="#" target="_blank" aria-label="TikTok" rel="noopener noreferrer">
                <!-- TikTok SVG Oficial -->
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48">
                    <g>
                        <path fill="#25F4EE" d="M41.5,15.5c-3.6,0-6.5-2.9-6.5-6.5h-4.5v24.2c0,3.7-3,6.8-6.8,6.8c-3.7,0-6.8-3-6.8-6.8c0-3.7,3-6.8,6.8-6.8c0.4,0,0.8,0,1.2,0.1v-4.6c-0.4,0-0.8-0.1-1.2-0.1c-6.3,0-11.4,5.1-11.4,11.4c0,6.3,5.1,11.4,11.4,11.4c6.3,0,11.4-5.1,11.4-11.4V21.9c1.9,1.1,4.1,1.7,6.5,1.7V15.5z"/>
                        <path fill="#FE2C55" d="M35,9v24.2c0,6.3-5.1,11.4-11.4,11.4c-6.3,0-11.4-5.1-11.4-11.4c0-6.3,5.1-11.4,11.4-11.4c0.4,0,0.8,0,1.2,0.1v4.6c-0.4,0-0.8-0.1-1.2-0.1c-3.7,0-6.8,3-6.8,6.8c0,3.7,3,6.8,6.8,6.8c3.7,0,6.8-3,6.8-6.8V9H35z"/>
                        <path fill="#fff" d="M41.5,21.9c-2.4,0-4.6-0.6-6.5-1.7v-4.6c1.9,1.1,4.1,1.7,6.5,1.7V21.9z"/>
                    </g>
                </svg>
            </a>
            <a href="#" target="_blank" aria-label="X / Twitter" rel="noopener noreferrer">
                <!-- X/Twitter SVG Oficial -->
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48" style="width: 20px; height: 20px;">
                    <path fill="#000" d="M41.5 8.5h-35c-1.66 0-3 1.34-3 3v25c0 1.66 1.34 3 3 3h35c1.66 0 3-1.34 3-3v-25c0-1.66-1.34-3-3-3zm-7.5 24.5h-3.5l-5.5-7.5-5.5 7.5h-3.5l7.5-10-7.5-10h3.5l5.5 7.5 5.5-7.5h3.5l-7.5 10 7.5 10z"/>
                </svg>
            </a>
            <a href="#" target="_blank" aria-label="WhatsApp" rel="noopener noreferrer">
                <!-- WhatsApp SVG Oficial -->
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48">
                    <g>
                        <path fill="#25D366" d="M4,42l2.9-10.6C5.2,28.1,4.5,25.6,4.5,23C4.5,12.8,13.3,4,23.5,4c5.1,0,9.9,2,13.5,5.6c3.6,3.6,5.6,8.4,5.6,13.5c0,10.2-8.8,19-19,19c-2.5,0-5-0.5-7.3-1.5L4,42z"/>
                        <path fill="#FFF" d="M20.1,15.6c-0.4-0.9-0.8-0.9-1.2-0.9c-0.3,0-0.7,0-1.1,0c-0.4,0-1,0.1-1.5,0.7c-0.5,0.6-2,2-2,4.8c0,2.8,2,5.5,2.3,5.9c0.3,0.4,3.9,6.2,9.5,8.2c1.3,0.4,2.3,0.7,3.1,0.9c1.3,0.3,2.5,0.3,3.4,0.2c1-0.1,3-1.2,3.4-2.4c0.4-1.2,0.4-2.2,0.3-2.4c-0.1-0.2-0.3-0.3-0.6-0.5c-0.3-0.2-1.7-0.8-2-0.9c-0.3-0.1-0.5-0.2-0.7,0.2c-0.2,0.3-0.8,1-1,1.2c-0.2,0.2-0.4,0.2-0.7,0.1c-0.3-0.1-1.4-0.5-2.7-1.6c-1-0.9-1.7-2-1.9-2.3c-0.2-0.3,0-0.5,0.1-0.7c0.1-0.1,0.3-0.4,0.5-0.6c0.2-0.2,0.2-0.4,0.3-0.6c0.1-0.2,0-0.4-0.1-0.6c-0.1-0.2-0.8-2-1.1-2.7C20.6,16.7,20.5,16.5,20.1,15.6z"/>
                    </g>
                </svg>
            </a>
            <a href="#" target="_blank" aria-label="LinkedIn" rel="noopener noreferrer">
                <!-- LinkedIn SVG Oficial -->
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48" style="width: 20px; height: 20px;">
                    <path fill="#0077B5" d="M42,4H6C4.9,4,4,4.9,4,6v36c0,1.1,0.9,2,2,2h36c1.1,0,2-0.9,2-2V6C44,4.9,43.1,4,42,4z"/>
                    <path fill="#fff" d="M14.5,19h5v15h-5V19z M17,17c-1.7,0-3-1.3-3-3s1.3-3,3-3s3,1.3,3,3S18.7,17,17,17z M34.5,34h-5v-7.5c0-1.8-0.7-3-2.5-3c-1.8,0-2.5,1.2-2.5,3V34h-5V19h5v2.1c0.7-1.1,2.1-2.1,4.1-2.1c3.1,0,5.4,2,5.4,6.1V34z"/>
                </svg>
            </a>
            <a href="#" target="_blank" aria-label="YouTube" rel="noopener noreferrer">
                <!-- YouTube SVG Oficial -->
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48" style="width: 20px; height: 20px;">
                    <path fill="#FF0000" d="M44.5,13.5c-0.5-2-2-3.5-4-4c-3.5-1-17.5-1-17.5-1s-14,0-17.5,1c-2,0.5-3.5,2-4,4c-1,3.5-1,10.5-1,10.5s0,7,1,10.5c0.5,2,2,3.5,4,4c3.5,1,17.5,1,17.5,1s14,0,17.5-1c2-0.5,3.5-2,4-4C45.5,23.5,45.5,16.5,44.5,13.5z"/>
                    <polygon fill="#fff" points="19,31 31,24 19,17"/>
                </svg>
            </a>
        </div>

        <div class="footer-nav">
            <span>&copy; 2025 Barbería, Inc. Todos los derechos reservados.</span>
        </div>
    </footer>
</body>
</html>
