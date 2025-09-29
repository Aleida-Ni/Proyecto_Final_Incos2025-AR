@extends('adminlte::auth.auth-page', ['auth_type' => 'login'])

@section('title', 'Iniciar sesión')

@section('auth_header', '')

@section('auth_body')
<div class="login-wrapper">
    <div class="login-glass">

        <!-- LOGO -->
        <div class="logo-container mb-3">
            <img src="{{ asset('storage/imagenes/logoStars.png') }}" alt="Logo" class="login-logo">
        </div>

        <h2 class="mb-4 text-center">Iniciar Sesión</h2>

        <form action="{{ route('login') }}" method="post">
            @csrf

            <!-- Correo -->
            <div class="mb-3">
                <x-adminlte-input name="correo" type="email" placeholder="usuario@correo.com" required autofocus icon="fas fa-user" />
            </div>

            <!-- Contraseña con ojo -->
            <div class="mb-3 position-relative">
                <x-adminlte-input 
                    id="contrasenia" 
                    name="contrasenia" 
                    type="password" 
                    placeholder="******" 
                    required 
                    icon="fas fa-lock" />
                <span class="password-toggle"><i class="fas fa-eye" id="toggleContrasenia"></i></span>
            </div>

            <button type="submit" class="btn btn-block custom-btn mt-2 mb-3">Ingresar</button>
        </form>

        <div class="text-center">
            <a href="{{ route('password.request') }}">¿Olvidaste tu contraseña?</a><br>
            <a href="{{ route('register') }}">Crear una cuenta</a>
        </div>
    </div>
</div>
@endsection

@push('css')
<style>
* { outline: none !important; }

/* Fondo completo */
body.login-page {
    margin: 0; padding: 0;
    background: url("{{ asset('imagenes/servicios/login-background.png') }}") no-repeat center center;
    background-size: cover;
    font-family: 'Nunito', sans-serif;
}

/* Contenedor central */
.login-wrapper {
    display: flex;
    justify-content: center;
    position: fixed;
    top: 100px;
    left: 0;
    width: 100%;
    height: auto;
}

/* Caja tipo glass */
.login-glass {
    background: rgba(255, 255, 255, 0.1); 
    border-radius: 20px;
    padding: 2rem;
    width: 100%;
    max-width: 420px;
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.4); 
    backdrop-filter: blur(12px) saturate(180%);
    -webkit-backdrop-filter: blur(12px) saturate(180%);
    border: 1px solid rgba(255, 255, 255, 0.2);
    color: white;
    text-align: center;
    transform: translateY(-80px);
}

/* Logo */
.logo-container { display: flex; justify-content: center; }
.login-logo { max-width: 120px; height: auto; margin-bottom: 15px; }

/* Título */
.login-glass h2 { font-weight: bold; color: #ffffff; }

/* Botón */
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

/* Links */
a { color: #93c5fd; font-size: 0.9rem; }
a:hover { color: #38bdf8; }

/* Inputs */
.input-group-text,
.form-control {
    background: rgba(255,255,255,0.15);
    border: none;
    color: white;
}

/* Posicionar el ojo sobre el input */
.position-relative { position: relative; }
.password-toggle {
    position: absolute;
    top: 50%;              /* Centrado vertical */
    right: 12px;           /* Separación del borde derecho */
    transform: translateY(-50%); /* Centrado exacto */
    cursor: pointer;
    color: #bbb;
    font-size: 1.1rem;
    z-index: 5;
    transition: 0.3s;
}
.password-toggle:hover { color: white; }
</style>
@endpush

@push('js')
<script>
document.addEventListener("DOMContentLoaded", () => {
    const input = document.getElementById("contrasenia");
    const toggle = document.getElementById("toggleContrasenia");
    if(input && toggle){
        toggle.addEventListener("click", () => {
            input.type = input.type === "password" ? "text" : "password";
            toggle.classList.toggle("fa-eye");
            toggle.classList.toggle("fa-eye-slash");
        });
    }
});
</script>
@endpush
