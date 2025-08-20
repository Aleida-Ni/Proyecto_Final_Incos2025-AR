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
            justify-content: flex-start; 
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
        <a href="https://www.facebook.com/tuBarberia" target="_blank" aria-label="Facebook" rel="noopener noreferrer">
            <!-- Facebook SVG -->
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" >
                <path d="M22.675 0h-21.35C.6 0 0 .6 0 1.325v21.351C0 23.4.6 24 1.325 24h11.495v-9.294H9.69v-3.622h3.13V8.413c0-3.1 1.894-4.788 4.66-4.788 1.325 0 2.466.099 2.797.143v3.24l-1.918.001c-1.504 0-1.796.715-1.796 1.764v2.313h3.59l-.467 3.622h-3.123V24h6.116C23.4 24 24 23.4 24 22.675v-21.35C24 .6 23.4 0 22.675 0z"/>
            </svg>
        </a>
        <a href="https://www.instagram.com/tuBarberia" target="_blank" aria-label="Instagram" rel="noopener noreferrer">
            <!-- Instagram SVG -->
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" >
                <path d="M7.75 2h8.5A5.75 5.75 0 0122 7.75v8.5A5.75 5.75 0 0116.25 22h-8.5A5.75 5.75 0 012 16.25v-8.5A5.75 5.75 0 017.75 2zm0 1.5a4.25 4.25 0 00-4.25 4.25v8.5a4.25 4.25 0 004.25 4.25h8.5a4.25 4.25 0 004.25-4.25v-8.5a4.25 4.25 0 00-4.25-4.25h-8.5zm8.5 2a1.25 1.25 0 110 2.5 1.25 1.25 0 010-2.5zm-4.25 1.5a5.5 5.5 0 110 11 5.5 5.5 0 010-11zm0 1.5a4 4 0 100 8 4 4 0 000-8z"/>
            </svg>
        </a>
    </footer>
</body>
</html>
