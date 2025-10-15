@extends('adminlte::auth.auth-page', ['auth_type' => 'login'])

@section('title', 'Verifica tu correo')

@push('css')
<style>
    :root {
        --primary-black: #1a1a1a;
        --dark-gray: #2d2d2d;
        --light-beige: #f8f5f2;
        --accent-gold: #d4af37;
        --shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .login-page {
        background: var(--light-beige);
        background-image: 
            radial-gradient(circle at 10% 20%, rgba(255, 255, 255, 0.8) 0%, transparent 20%),
            radial-gradient(circle at 90% 80%, rgba(255, 255, 255, 0.6) 0%, transparent 20%);
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .login-box {
        width: 100%;
        max-width: 480px;
        margin: 0 auto;
    }

    .login-logo {
        margin-bottom: 2rem;
        text-align: center;
        position: relative;
    }

    .logo-container {
        position: relative;
        display: inline-block;
        padding: 15px;
    }

    .logo-img {
        max-width: 180px;
        height: auto;
        filter: drop-shadow(0 4px 8px rgba(0, 0, 0, 0.3));
        transition: transform 0.3s ease;
    }

    .logo-img:hover {
        transform: scale(1.05);
    }

    .logo-shine {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(
            125deg,
            transparent 0%,
            rgba(255, 255, 255, 0.4) 50%,
            transparent 100%
        );
        opacity: 0;
        animation: shine 3s infinite;
        border-radius: 50%;
    }

    @keyframes shine {
        0% {
            opacity: 0;
            transform: translateX(-100%);
        }
        20% {
            opacity: 0.5;
        }
        100% {
            opacity: 0;
            transform: translateX(200%);
        }
    }

    .login-card {
        background: white;
        border-radius: 12px;
        box-shadow: var(--shadow);
        padding: 2.5rem;
        position: relative;
        overflow: hidden;
        border: 1px solid rgba(0, 0, 0, 0.05);
    }

    .login-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: var(--primary-black);
    }

    .card-header {
        text-align: center;
        margin-bottom: 1.5rem;
    }

    .card-title {
        font-size: 1.8rem;
        font-weight: 700;
        color: var(--primary-black);
        margin-bottom: 0.5rem;
        letter-spacing: -0.5px;
    }

    .card-subtitle {
        color: #666;
        font-size: 1rem;
        line-height: 1.5;
    }

    .verification-icon {
        text-align: center;
        margin: 1.5rem 0;
    }

    .icon-container {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 80px;
        height: 80px;
        background: var(--light-beige);
        border-radius: 50%;
        position: relative;
    }

    .icon-container i {
        font-size: 2.5rem;
        color: var(--primary-black);
    }

    .icon-pulse {
        position: absolute;
        width: 100%;
        height: 100%;
        border-radius: 50%;
        border: 2px solid var(--accent-gold);
        animation: pulse 2s infinite;
    }

    @keyframes pulse {
        0% {
            transform: scale(1);
            opacity: 1;
        }
        100% {
            transform: scale(1.2);
            opacity: 0;
        }
    }

    .alert {
        border-radius: 8px;
        border: none;
        padding: 1rem 1.25rem;
        margin-bottom: 1.5rem;
    }

    .alert-success {
        background: rgba(40, 167, 69, 0.1);
        color: #155724;
        border-left: 4px solid #28a745;
    }

    .btn-primary {
        background: var(--primary-black);
        border: none;
        border-radius: 6px;
        color: white;
        font-weight: 600;
        padding: 0.75rem 1.5rem;
        width: 100%;
        transition: all 0.3s ease;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        font-size: 0.95rem;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .btn-primary:hover {
        background: #000;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
    }

    .btn-primary:active {
        transform: translateY(0);
    }

    .login-links {
        text-align: center;
        margin-top: 1.5rem;
        padding-top: 1.5rem;
        border-top: 1px solid #eee;
    }

    .login-links a {
        color: var(--primary-black);
        text-decoration: none;
        font-weight: 500;
        transition: color 0.2s ease;
    }

    .login-links a:hover {
        color: #000;
        text-decoration: underline;
    }

    .steps {
        display: flex;
        justify-content: space-between;
        margin: 2rem 0 1.5rem;
        position: relative;
    }

    .steps::before {
        content: '';
        position: absolute;
        top: 15px;
        left: 0;
        right: 0;
        height: 2px;
        background: #eee;
        z-index: 1;
    }

    .step {
        display: flex;
        flex-direction: column;
        align-items: center;
        position: relative;
        z-index: 2;
    }

    .step-number {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background: var(--primary-black);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        margin-bottom: 0.5rem;
        font-size: 0.9rem;
    }

    .step-text {
        font-size: 0.8rem;
        color: #666;
        text-align: center;
    }

    .step.active .step-number {
        background: var(--accent-gold);
    }

    .step.active .step-text {
        color: var(--primary-black);
        font-weight: 600;
    }

    /* Responsive */
    @media (max-width: 576px) {
        .login-card {
            padding: 2rem 1.5rem;
            margin: 0 1rem;
        }
        
        .card-title {
            font-size: 1.5rem;
        }
        
        .logo-img {
            max-width: 140px;
        }
    }
</style>
@endpush

@section('auth_body')
<div class="login-card">
    <div class="card-header">
        <div class="login-logo">
            <div class="logo-container">
                <a href="{{ url('/') }}">
                    <img src="{{ asset('storage/imagenes/logoStars.png') }}" alt="Logo" class="logo-img">
                    <div class="logo-shine"></div>
                </a>
            </div>
        </div>
        
        <h1 class="card-title">Verifica tu correo electrónico</h1>
        <p class="card-subtitle">
            Para completar tu registro, necesitamos verificar tu dirección de correo electrónico.
        </p>
    </div>

    <div class="steps">
        <div class="step">
            <div class="step-number">1</div>
            <div class="step-text">Registro</div>
        </div>
        <div class="step active">
            <div class="step-number">2</div>
            <div class="step-text">Verificación</div>
        </div>
        <div class="step">
            <div class="step-number">3</div>
            <div class="step-text">Completado</div>
        </div>
    </div>

    <div class="verification-icon">
        <div class="icon-container">
            <i class="fas fa-envelope"></i>
            <div class="icon-pulse"></div>
        </div>
    </div>

    <p class="text-center mb-4">
        Hemos enviado un enlace de verificación a tu dirección de correo electrónico.<br>
        Por favor, revisa tu bandeja de entrada y haz clic en el enlace para continuar.
    </p>

    @if (session('message'))
        <div class="alert alert-success">
            <i class="fas fa-check-circle mr-2"></i>
            {{ session('message') }}
        </div>
    @endif

    <form method="POST" action="{{ route('verification.send') }}">
        @csrf
        <button type="submit" class="btn btn-primary">
            <i class="fas fa-paper-plane mr-2"></i>
            Reenviar enlace de verificación
        </button>
    </form>

    <div class="login-links">
        <a href="{{ route('logout') }}" 
           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <i class="fas fa-sign-out-alt mr-1"></i>
            Cerrar sesión
        </a>
        
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
            @csrf
        </form>
    </div>
</div>
@endsection

@push('js')
<!-- Font Awesome para iconos -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Efecto de escritura para el título
        const title = document.querySelector('.card-title');
        const originalText = title.textContent;
        title.textContent = '';
        
        let i = 0;
        const typeWriter = () => {
            if (i < originalText.length) {
                title.textContent += originalText.charAt(i);
                i++;
                setTimeout(typeWriter, 50);
            }
        };
        
        // Iniciar efecto después de un breve retraso
        setTimeout(typeWriter, 300);
        
        // Añadir efecto de aparición gradual a los elementos
        const elements = document.querySelectorAll('.login-card > *');
        elements.forEach((el, index) => {
            el.style.opacity = '0';
            el.style.transform = 'translateY(20px)';
            setTimeout(() => {
                el.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
                el.style.opacity = '1';
                el.style.transform = 'translateY(0)';
            }, 300 + (index * 100));
        });
    });
</script>
@endpush