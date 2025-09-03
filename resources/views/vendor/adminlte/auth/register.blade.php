@extends('adminlte::auth.auth-page', ['auth_type' => 'register'])

@section('title', 'Registrarse')

@section('auth_header', '')

@section('auth_body')
<div class="register-wrapper">
    <div class="register-glass">

        <!-- Íconos redes sociales -->
        <div class="social-icons mb-4">
            <a href="#"><i class="fab fa-facebook-f"></i></a>
            <a href="#"><i class="fab fa-instagram"></i></a>
            <a href="#"><i class="fab fa-tiktok"></i></a>
        </div>

        <h2 class="mb-4 text-center">Registro</h2>

        <form action="{{ route('register') }}" method="post" autocomplete="off">
            @csrf

            <div class="mb-3">
                <x-adminlte-input name="nombre" type="text" placeholder="Tu nombre" required autofocus icon="fas fa-user" />
            </div>

            <div class="mb-3 row">
                <div class="col">
                    <x-adminlte-input name="apellido_paterno" type="text" placeholder="Apellido paterno" required icon="fas fa-user" />
                </div>
                <div class="col">
                    <x-adminlte-input name="apellido_materno" type="text" placeholder="Apellido materno" required icon="fas fa-user" />
                </div>
            </div>

            <div class="mb-3 row">
                <div class="col">
                    <x-adminlte-input name="correo" type="email" placeholder="correo@ejemplo.com" required icon="fas fa-envelope" />
                </div>
                <div class="col">
                    <x-adminlte-input name="telefono" type="tel" placeholder="Ej: 76543210" required icon="fas fa-phone" />
                </div>
            </div>

            <div class="mb-3">
                <x-adminlte-input name="fecha_nacimiento" type="date" required icon="fas fa-calendar-alt" />
            </div>

            <div class="mb-3 row">
                <div class="col position-relative">
                    <x-adminlte-input id="contraseña" name="contraseña" type="password" placeholder="*******" required icon="fas fa-lock" />
                    <span class="password-toggle"><i class="fas fa-eye" id="toggleContraseña"></i></span>
                </div>
                <div class="col position-relative">
                    <x-adminlte-input id="contraseña_confirmation" name="contraseña_confirmation" type="password" placeholder="*******" required icon="fas fa-lock" />
                    <span class="password-toggle"><i class="fas fa-eye" id="toggleContraseñaConfirm"></i></span>
                </div>
            </div>

            <button type="submit" class="btn btn-block custom-btn mt-2 mb-3">Registrarse</button>
        </form>

        <div class="text-center">
            <a href="{{ route('login') }}">¿Ya tienes una cuenta? Inicia sesión</a>
        </div>

    </div>
</div>
@endsection

@push('css')
<style>
    /* Aseguramos que todo el contenedor de AuthPage tenga tu fondo */
    html, body, .auth-page {
        height: 100%;
        margin: 0;
        padding: 0;
        background: url("{{ asset('storage/imagenes/loginfondo2.jpg') }}") no-repeat center center fixed !important;
        background-size: cover !important;
        font-family: 'Nunito', sans-serif;
    }
        /* Anula el fondo blanco que viene por defecto */
.login-box, 
.login-box .card, 
.login-box .card-body, 
.login-box .card-header {
    background: transparent !important;
    box-shadow: none !important;
    border: none !important;
}

    /* Caja tipo vidrio centrada */
    .register-wrapper {
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
        width: 100%;
        padding: 1rem;
    }

    .register-glass {
        background: rgba(255, 255, 255, 0.1);
        border-radius: 20px;
        padding: 2rem;
        width: 100%;
        max-width: 450px;
        box-shadow: 0 8px 32px rgba(0,0,0,0.4);
        backdrop-filter: blur(12px) saturate(180%);
        -webkit-backdrop-filter: blur(12px) saturate(180%);
        border: 1px solid rgba(255,255,255,0.2);
        color: white;
        text-align: center;
    }

    .register-glass h2 {
        font-weight: bold;
        color: #ffffff;
    }

    /* Botón mostrar/ocultar contraseña */
    .position-relative { position: relative; }
    .password-toggle {
        position: absolute;
        top: 38px;
        right: 12px;
        cursor: pointer;
        color: #bbb;
        font-size: 1.1rem;
        transition: 0.3s;
    }
    .password-toggle:hover { color: white; }

    .custom-btn {
        background: linear-gradient(135deg, #3b82f6, #06b6d4);
        color: white;
        border: none;
        border-radius: 8px;
        padding: 0.6rem;
        font-weight: bold;
        text-transform: uppercase;
        transition: 0.3s ease;
    }
    .custom-btn:hover {
        background: linear-gradient(135deg, #2563eb, #0891b2);
    }

    .form-control, .input-group-text {
        background: rgba(255,255,255,0.15);
        border: none;
        color: white;
    }

    a { color: #93c5fd; font-size: 0.9rem; }
    a:hover { color: #38bdf8; }

    .social-icons {
        display: flex;
        justify-content: center;
        gap: 15px;
        margin-bottom: 1rem;
    }
    .social-icons a {
        width: 45px;
        height: 45px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgba(255,255,255,0.2);
        border-radius: 50%;
        font-size: 18px;
        color: white;
        transition: 0.3s ease;
    }
    .social-icons a:hover {
        background: rgba(255,255,255,0.4);
        transform: scale(1.1);
    }

    @media (max-width: 768px) {
        .register-glass { width: 90%; padding: 1.5rem; }
        .password-toggle { top: 35px; right: 8px; }
    }
</style>
@endpush


@push('js')
<script>
    // Mostrar / ocultar contraseña
    const togglePassword = (toggleId, inputId) => {
        const toggle = document.getElementById(toggleId);
        const input = document.getElementById(inputId);
        toggle.addEventListener('click', () => {
            if (input.type === 'password') {
                input.type = 'text';
                toggle.classList.remove('fa-eye');
                toggle.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                toggle.classList.remove('fa-eye-slash');
                toggle.classList.add('fa-eye');
            }
        });
    }

    togglePassword('toggleContraseña', 'contraseña');
    togglePassword('toggleContraseñaConfirm', 'contraseña_confirmation');
</script>
@endpush