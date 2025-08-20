@extends('adminlte::auth.auth-page', ['auth_type' => 'login'])

@section('title', 'Iniciar sesión')

@section('auth_header', '')

@section('auth_body')
<div class="login-wrapper">
    <div class="login-glass">

        <!-- Íconos redes sociales -->
        <div class="social-icons mb-4">
            <a href="#"><i class="fab fa-facebook-f"></i></a>
            <a href="#"><i class="fab fa-instagram"></i></a>
            <a href="#"><i class="fab fa-tiktok"></i></a>
        </div>

        <h2 class="mb-4 text-center">Acceso</h2>

        <form action="{{ route('login') }}" method="post">
            @csrf

            <div class="mb-3">
                <x-adminlte-input name="correo" type="email" placeholder="usuario@correo.com" required autofocus icon="fas fa-user" />
            </div>

            <div class="mb-3">
                <x-adminlte-input name="contraseña" type="password" placeholder="******" required icon="fas fa-lock" />
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
    body.login-page {
        margin: 0; padding: 0;
        background: url("{{ asset('storage/imagenes/loginfondo2.jpg') }}") no-repeat center center fixed;
        background-size: cover;
    }
    .login-wrapper {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
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

/* Anula el fondo blanco que viene por defecto */
.login-box, .card, .auth-box {
    background: transparent !important;
    box-shadow: none !important;
    border: none !important;
}

/* Ahora tu efecto vidrio */
.login-glass {
    background: rgba(255, 255, 255, 0.1); /* transparente */
    border-radius: 20px;
    padding: 2rem;
    width: 100%;
    max-width: 400px;
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.4); /* sombra tipo glass */
    backdrop-filter: blur(12px) saturate(180%);
    -webkit-backdrop-filter: blur(12px) saturate(180%);
    border: 1px solid rgba(255, 255, 255, 0.2);
    color: white;
    text-align: center;
}

    .login-glass h2 {
        font-weight: bold;
        color: #0a0a0aff;
    }
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
    a { color: #93c5fd; font-size: 0.9rem; }
    a:hover { color: #38bdf8; }
    .input-group-text {
        background: rgba(255,255,255,0.15);
        border: none;
        color: white;
    }
    .form-control {
        background: rgba(255,255,255,0.15);
        border: none;
        color: white;
    }

    /* Íconos sociales */
    .social-icons {
        display: flex;
        justify-content: center;
        gap: 15px;
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
</style>
@endpush
