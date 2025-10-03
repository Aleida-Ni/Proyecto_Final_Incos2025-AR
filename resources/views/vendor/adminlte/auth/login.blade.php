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
            <div class="mb-3 text-start">
                <label for="correo" class="form-label">Ingresar correo</label>
                <x-adminlte-input id="correo" name="correo" type="email" placeholder="usuario@correo.com" required autofocus icon="fas fa-user" />
            </div>

            <!-- Contraseña con ojo -->
            <div class="mb-3 text-start position-relative">
                <label for="contrasenia" class="form-label">Contraseña</label>
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

        <div class="text-center mt-2">
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
    background: #c8c6c68b !important;
    align-items: center;   /* Fondo blanco */
    font-family: 'Nunito', sans-serif;
    color: #333;
}

/* Contenedor central */
.login-wrapper { display: flex;
    justify-content: center; 
    position: fixed; 
    top: 100px; 
    left: 0; 
    width: 100%; 
    height: auto; 
}

/* Caja tipo glass */
.login-glass {
    background: rgba(245, 245, 245, 0.7);  /* gris muy claro/plomo */
    border-radius: 12px;
    padding: 2rem;
    width: 100%;
    max-width: 420px;
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1); 
    backdrop-filter: blur(12px) saturate(180%);
    -webkit-backdrop-filter: blur(12px) saturate(180%);
    border: 1px solid rgba(0, 0, 0, 0.1);
    text-align: initial;
    transform: translateY(-80px); 
}

/* Logo */
.logo-container { display: flex; justify-content: center; }
.login-logo { max-width: 120px; height: auto; margin-bottom: 15px; 
    filter: drop-shadow(0px 0px 6px rgba(0,0,0,0.8));}

/* Título */
.login-glass h2 { font-weight: bold; color: #111; }

/* Botón */
.custom-btn {
    background: #000;     /* negro */
    color: #fff;
    border: none;
    border-radius: 6px;   /* bordes cuadrados */
    padding: 0.6rem;
    font-weight: bold;
    text-transform: uppercase;
    transition: 0.3s ease;
}
.custom-btn:hover {
    background: #444;  /* plomo oscuro al hover */
}

/* Links */
a { color: #555; font-size: 0.9rem; }
a:hover { color: #000; }

/* Inputs */
.input-group-text,
.form-control {
    background: rgba(255,255,255,0.9);
    border: 1px solid #ccc;
    color: #000;
}
.form-label {
    font-size: 0.9rem;
    font-weight: 600;
    color: #333;
}

/* Posicionar el ojo sobre el input */
.position-relative { position: relative; }
.password-toggle {
    position: absolute;
    top: 65%;              /* centrado respecto al input */
    right: 12px;           
    transform: translateY(-50%); 
    cursor: pointer;
    color: #555;
    font-size: 1.1rem;
    z-index: 5;
    transition: 0.3s;
}
.password-toggle:hover { color: #000; }
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
