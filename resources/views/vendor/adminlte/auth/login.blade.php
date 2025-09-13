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

        <h2 class="mb-4 text-center">Acceso</h2>

        <form action="{{ route('login') }}" method="post">
            @csrf

            <div class="mb-3">
                <x-adminlte-input name="correo" type="email" placeholder="usuario@correo.com" required autofocus icon="fas fa-user" />
            </div>

            <div class="mb-3">
                <x-adminlte-input name="contrasenia" id="contrasenia" type="password" placeholder="******" required>
                    <x-slot name="appendSlot">
                        <div class="input-group-text">
                            <i id="toggleContrasenia" class="fas fa-eye" style="cursor: pointer"></i>
                        </div>
                    </x-slot>
                </x-adminlte-input>
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
        background: url("{{ asset('imagenes/servicios/login-background.png') }}") no-repeat center center fixed;
        background-size: cover;
    }

    .login-wrapper {
        display: flex;
        justify-content: center;
        position: fixed;
        top: 100px;
        left: 0;
        width: 100%;
        height: auto;
    }

    .login-box, 
    .login-box .card, 
    .login-box .card-body, 
    .login-box .card-header {
        background: transparent !important;
        box-shadow: none !important;
        border: none !important;
    }

    .login-box, .card, .auth-box {
        background: transparent !important;
        box-shadow: none !important;
        border: none !important;
    }

    .login-glass {
        background: rgba(255, 255, 255, 0.1); 
        border-radius: 20px;
        padding: 2rem;
        width: 100%;
        max-width: 400px;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.4); 
        backdrop-filter: blur(12px) saturate(180%);
        -webkit-backdrop-filter: blur(12px) saturate(180%);
        border: 1px solid rgba(255, 255, 255, 0.2);
        color: white;
        text-align: center;
        transform: translateY(-80px);
    }

    /* LOGO */
    .logo-container {
        display: flex;
        justify-content: center;
    }
    .login-logo {
        max-width: 120px;
        height: auto;
        margin-bottom: 10px;
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

@push('js')
<script>
    // Mostrar / ocultar contraseña
    document.getElementById("toggleContrasenia").addEventListener("click", function() {
        const input = document.getElementById("contrasenia");
        if (input.type === "password") {
            input.type = "text";
            this.classList.remove("fa-eye");
            this.classList.add("fa-eye-slash");
        } else {
            input.type = "password";
            this.classList.remove("fa-eye-slash");
            this.classList.add("fa-eye");
        }
    });
</script>
@endpush
