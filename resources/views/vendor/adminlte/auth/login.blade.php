@extends('adminlte::auth.auth-page', ['auth_type' => 'login'])
@section('title', 'Iniciar Sesión - Barbería Elite')
@section('auth_header', '')
@section('auth_body')
<div class="login-wrapper">
    <div class="login-glass">
        <!-- LOGO -->
        <div class="logo-container mb-3">
            <img src="{{ asset('storage/imagenes/logoStars.png') }}" alt="Barbería Elite" class="login-logo">
        </div>

        <h2 class="mb-3 text-center">Iniciar Sesión</h2>

        <form action="{{ route('login') }}" method="post">
            @csrf

            <!-- Correo -->
            <div class="mb-2 text-start">
                <label for="correo" class="form-label">Correo Electrónico</label>
                <x-adminlte-input id="correo" name="correo" type="email" 
                    placeholder="usuario@correo.com" 
                    required autofocus 
                    icon="fas fa-envelope" 
                    class="custom-input" />
            </div>

            <!-- Contraseña con ojo -->
            <div class="mb-2 text-start position-relative">
                <label for="contrasenia" class="form-label">Contraseña</label>
                <x-adminlte-input 
                    id="contrasenia" 
                    name="contrasenia" 
                    type="password" 
                    placeholder="******" 
                    required 
                    icon="fas fa-lock" 
                    class="custom-input" />
                <span class="password-toggle">
                    <i class="fas fa-eye" id="toggleContrasenia"></i>
                </span>
            </div>

            <button type="submit" class="btn btn-block custom-btn mt-2 mb-2">
                <i class="fas fa-sign-in-alt me-2"></i>Ingresar
            </button>
        </form>

        <div class="text-center mt-2">
            <a href="{{ route('password.request') }}" class="auth-link">
                <i class="fas fa-key me-1"></i>¿Olvidaste tu contraseña?
            </a><br>
            <a href="{{ route('register') }}" class="auth-link mt-1">
                <i class="fas fa-user-plus me-1"></i>Crear una cuenta
            </a>
        </div>
    </div>
</div>
@endsection

@push('css')
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
    outline: none !important;
}

/* Fondo fijo y centrado */
body.login-page {
    margin: 0; 
    padding: 0;
    background: linear-gradient(135deg, var(--color-beige) 0%, var(--color-blanco) 100%) !important;
    font-family: 'Roboto', sans-serif;
    color: var(--color-gris-oscuro);
    height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden; /* evita desplazamiento */
}

/* Elimina estilos de adminlte */
.login-box, .login-box .card, .login-box .card-body, .login-box .card-header {
    background: transparent !important;
    box-shadow: none !important;
    border: none !important;
}

/* Contenedor principal */
.login-wrapper { 
    display: flex;
    justify-content: center;
    align-items: center;
    width: 100%;
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%); /* Centrado exacto */
}

/* Caja tipo glass - más compacta */
.login-glass {
    background: rgba(255, 255, 255, 0.9);
    border-radius: 20px;
    padding: 2.5rem 2.8rem;
    width: 100%;
    max-width: 430px;
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
    backdrop-filter: blur(10px);
    -webkit-backdrop-filter: blur(10px);
    border: 2px solid var(--color-dorado); /* borde dorado */
    text-align: center;
}

/* Logo centrado */
.logo-container { 
    display: flex; 
    justify-content: center; 
    margin-bottom: 1rem; /* Reducido */
}
.login-logo { 
    max-width: 130px; 
    height: auto; 
    filter: drop-shadow(0 0 10px rgba(0,0,0,0.6)) 
            drop-shadow(0 0 20px rgba(0,0,0,0.3)); /* sombras negras elegantes */
    transition: all 0.3s ease;
}
.login-logo:hover {
    filter: drop-shadow(0 0 20px rgba(0,0,0,0.8)) 
            drop-shadow(0 0 25px rgba(0,0,0,0.5)); /* más brillo al pasar el mouse */
    transform: scale(1.03);
}

/* Título - tamaño reducido */
.login-glass h2 { 
    font-weight: 700; 
    color: var(--color-gris-oscuro); 
    font-family: 'Oswald', sans-serif;
    font-size: 1.5rem; /* Reducido */
    margin-bottom: 1rem; /* Reducido */
}

/* Labels */
.form-label {
    font-size: 0.9rem;
    font-weight: 600;
    color: var(--color-gris-oscuro);
    margin-bottom: 0.4rem;
    display: block;
    text-align: left;
}

/* Inputs personalizados */
.custom-input .form-control {
    border: 1.8px solid var(--color-gris-medio) !important;
    border-radius: 8px !important;
    background: var(--color-blanco) !important;
    color: var(--color-gris-oscuro) !important;
    padding: 0.7rem !important;
    transition: all 0.3s ease !important;
    font-size: 0.95rem;
}

.custom-input .form-control:focus {
    border-color: var(--color-dorado) !important;
    box-shadow: 0 0 0 0.2rem rgba(212, 175, 55, 0.25) !important;
}

/* Icono de input */
.custom-input .input-group-text {
    border: 1.8px solid var(--color-gris-medio) !important;
    border-right: none !important;
    background: linear-gradient(135deg, var(--color-dorado) 0%, var(--color-dorado-claro) 100%) !important;
    color: var(--color-negro) !important;
    border-radius: 8px 0 0 8px !important;
    font-weight: 600;
}

/* Botón mostrar/ocultar contraseña - posición mejorada */
.password-toggle {
    position: absolute;
    top: 65%; /* Ajustado para mejor alineación */
    right: 15px;
    transform: translateY(-50%);
    cursor: pointer;
    color: var(--color-gris-medio);
    font-size: 1.1rem;
    z-index: 5;
    background: var(--color-blanco);
    padding: 6px 10px;
    border-radius: 6px;
    border: 1px solid var(--color-gris-medio);
    transition: all 0.3s ease;
}
.password-toggle:hover { 
    color: var(--color-dorado);
    border-color: var(--color-dorado);
    background: var(--color-beige);
}

/* Botón principal */
.custom-btn {
    background: var(--color-negro);
    color: var(--color-blanco);
    border-radius: 8px;
    padding: 0.75rem;
    font-weight: 700;
    text-transform: uppercase;
    transition: all 0.3s ease;
    width: 100%;
    font-size: 1rem;
}
.custom-btn:hover {
    background: var(--color-dorado);
    color: var(--color-negro);
    transform: translateY(-2px);
}

/* Links */
.auth-link {
    color: var(--color-gris-oscuro);
    font-size: 0.9rem;
    font-weight: 600;
    text-decoration: none;
    transition: color 0.3s ease;
    display: inline-block;
    margin: 0.25rem 0;
}
.auth-link:hover {
    color: var(--color-dorado);
    text-decoration: underline;
}

/* Responsive */
@media (max-width: 576px) {
    .login-glass {
        width: 90%;
        padding: 1.5rem 1.2rem; /* Reducido para móviles */
        max-width: 90%;
    }
    .login-logo {
        max-width: 100px;
    }
}
</style>
@endpush

@push('js')
<script>
document.addEventListener("DOMContentLoaded", () => {
    // Make password toggle resilient to different markup generated by x-adminlte-input
    document.querySelectorAll('.password-toggle').forEach(toggle => {
        toggle.setAttribute('role', 'button');
        toggle.setAttribute('tabindex', '0');
        const handler = () => {
            // try to find the nearest input inside the same position-relative container
            const container = toggle.closest('.position-relative') || toggle.parentElement;
            const input = container ? container.querySelector('input[type="password"], input[type="text"]') : null;
            if (!input) return;
            if (input.type === 'password') {
                input.type = 'text';
                toggle.classList.remove('fa-eye');
                toggle.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                toggle.classList.remove('fa-eye-slash');
                toggle.classList.add('fa-eye');
            }
        };
        toggle.addEventListener('click', handler);
        toggle.addEventListener('keypress', (e) => { if (e.key === 'Enter' || e.key === ' ') { e.preventDefault(); handler(); } });
    });
});
</script>
@endpush