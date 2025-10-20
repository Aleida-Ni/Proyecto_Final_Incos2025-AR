@extends('adminlte::auth.auth-page', ['auth_type' => 'register'])
@section('title', 'Registrarse - Barbería Elite')
@section('auth_header', '')
@section('auth_body')
<div class="register-wrapper">
    <div class="register-glass">
        <!-- Logo -->
        <div class="logo-container mb-4">
            <img src="{{ asset('storage/imagenes/logoStars.png') }}" alt="Barbería Elite" class="register-logo">
        </div>

        <h2 class="mb-4 text-center">Crear Cuenta</h2>
        
        <form action="{{ route('register') }}" method="post" autocomplete="off" id="registerForm">
            @csrf
            
            <!-- Nombre -->
            <div class="mb-3 text-start">
                <label class="form-label">Nombre</label>
                <x-adminlte-input name="nombre" type="text" placeholder="Tu nombre" 
                    pattern="^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]{2,30}$" maxlength="30" 
                    title="Solo se permiten letras y espacios (2 a 30 caracteres)" 
                    required autofocus icon="fas fa-user" 
                    class="custom-input" />
            </div>

            <!-- Apellidos -->
            <div class="mb-3 row g-3">
                <div class="col text-start">
                    <label class="form-label">Primer Apellido</label>
                    <x-adminlte-input name="apellido_paterno" type="text" placeholder="Primer Apellido" 
                        pattern="^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]{2,30}$" maxlength="30" 
                        title="Solo se permiten letras y espacios (2 a 30 caracteres)" 
                        required icon="fas fa-user" 
                        class="custom-input" />
                </div>
                <div class="col text-start">
                    <label class="form-label">Segundo Apellido</label>
                    <x-adminlte-input name="apellido_materno" type="text" placeholder="Segundo Apellido" 
                        pattern="^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]{2,30}$" maxlength="30" 
                        title="Solo se permiten letras y espacios (2 a 30 caracteres)" 
                        required icon="fas fa-user" 
                        class="custom-input" />
                </div>
            </div>

            <!-- Correo y Teléfono -->
            <div class="mb-3 row g-3">
                <div class="col text-start">
                    <label class="form-label">Correo Electrónico</label>
                    <x-adminlte-input name="correo" type="email" placeholder="correo@ejemplo.com" 
                        required icon="fas fa-envelope" 
                        class="custom-input" />
                </div>
                <div class="col text-start">
                    <label class="form-label">Teléfono</label>
                    <x-adminlte-input name="telefono" type="tel" placeholder="Ej: 76543210" 
                        pattern="[0-9]{8,10}" 
                        title="Debe contener entre 8 y 10 dígitos numéricos" 
                        required icon="fas fa-phone" 
                        class="custom-input" />
                </div>
            </div>

            <!-- Fecha Nacimiento -->
            <div class="mb-3 text-start">
                <label class="form-label">Fecha de Nacimiento</label>
                <x-adminlte-input name="fecha_nacimiento" type="date" 
                    required icon="fas fa-calendar-alt" 
                    class="custom-input" />
            </div>

            <!-- Contraseña -->
            <div class="mb-3 row g-3">
                <div class="col text-start position-relative">
                    <label class="form-label">Contraseña</label>
                    <x-adminlte-input id="contrasenia" name="contrasenia" type="password" 
                        placeholder="*******" 
                        pattern="(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}" 
                        title="Mínimo 8 caracteres, con letras y números" 
                        required icon="fas fa-lock" 
                        class="custom-input" />
                    <span class="password-toggle">
                        <i class="fas fa-eye" id="toggleContrasenia"></i>
                    </span>
                </div>
                <div class="col text-start position-relative">
                    <label class="form-label">Confirmar Contraseña</label>
                    <x-adminlte-input id="contrasenia_confirmation" name="contrasenia_confirmation" 
                        type="password" placeholder="*******" 
                        required icon="fas fa-lock" 
                        class="custom-input" />
                    <span class="password-toggle">
                        <i class="fas fa-eye" id="toggleContraseniaConfirm"></i>
                    </span>
                </div>
            </div>

            <button type="submit" class="btn btn-block custom-btn mt-3 mb-3">
                <i class="fas fa-user-plus me-2"></i>Registrarse
            </button>
        </form>

        <div class="text-center">
            <a href="{{ route('login') }}" class="login-link">
                <i class="fas fa-sign-in-alt me-1"></i>¿Ya tienes una cuenta? Inicia sesión
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

/* Fondo elegante */
html, body, .auth-page {
    height: 100%;
    margin: 0;
    padding: 0;
    background: linear-gradient(135deg, var(--color-beige) 0%, var(--color-blanco) 100%) !important;
    background-size: cover !important;
    font-family: 'Roboto', sans-serif;
}

/* Anula estilos por defecto de AdminLTE */
.login-box, .login-box .card, .login-box .card-body, .login-box .card-header {
    background: transparent !important;
    box-shadow: none !important;
    border: none !important;
    max-width: none !important;
    width: auto !important;
}

.register-wrapper {
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
    width: 100%;
    padding: 1rem;
}

.register-glass {
    background: rgba(255, 255, 255, 0.85);
    border-radius: 15px;
    padding: 2.5rem;
    width: 100%;
    max-width: 500px;
    box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
    backdrop-filter: blur(15px);
    -webkit-backdrop-filter: blur(15px);
    border: 2px solid var(--color-dorado);
    text-align: initial;
}

/* Logo */
.logo-container {
    display: flex;
    justify-content: center;
    margin-bottom: 1.5rem;
}

.register-logo {
    max-width: 140px;
    height: auto;
    filter: drop-shadow(0 4px 8px rgba(13, 13, 13, 0.3));
}

/* Título */
.register-glass h2 {
    font-weight: 700;
    color: var(--color-gris-oscuro);
    font-family: 'Oswald', sans-serif;
    font-size: 2rem;
    text-align: center;
    margin-bottom: 2rem;
}

/* Labels */
.form-label {
    font-size: 0.9rem;
    font-weight: 600;
    color: var(--color-gris-oscuro);
    margin-bottom: 0.5rem;
}

/* Inputs personalizados */
.custom-input .form-control {
    border: 2px solid var(--color-gris-medio) !important;
    border-radius: 8px !important;
    background: var(--color-blanco) !important;
    color: var(--color-gris-oscuro) !important;
    padding: 0.75rem !important;
    transition: all 0.3s ease !important;
    font-size: 0.95rem;
}

.custom-input .form-control:focus {
    border-color: var(--color-dorado) !important;
    box-shadow: 0 0 0 0.2rem rgba(212, 175, 55, 0.25) !important;
    background: var(--color-blanco) !important;
}

.custom-input .input-group-text {
    border: 2px solid var(--color-gris-medio) !important;
    border-right: none !important;
    background: linear-gradient(135deg, var(--color-dorado) 0%, var(--color-dorado-claro) 100%) !important;
    color: var(--color-negro) !important;
    border-radius: 8px 0 0 8px !important;
    font-weight: 600;
}

.custom-input .form-control:focus + .input-group-text,
.custom-input:focus-within .input-group-text {
    border-color: var(--color-dorado) !important;
}

/* Botón mostrar/ocultar contraseña */
.position-relative {
    position: relative;
}

.password-toggle {
    position: absolute;
    top: 70%;
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
    background: linear-gradient(135deg, var(--color-dorado) 0%, var(--color-dorado-claro) 100%);
    color: var(--color-negro);
    border: 2px solid var(--color-dorado);
    border-radius: 8px;
    padding: 0.75rem;
    font-weight: 700;
    text-transform: uppercase;
    transition: all 0.3s ease;
    width: 100%;
    font-size: 1rem;
    box-shadow: 0 4px 15px rgba(212, 175, 55, 0.3);
}

.custom-btn:hover {
    background: var(--color-negro);
    color: var(--color-dorado);
    border-color: var(--color-negro);
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(212, 175, 55, 0.4);
}

/* Links */
.login-link {
    color: var(--color-gris-oscuro);
    font-size: 0.9rem;
    font-weight: 600;
    text-decoration: none;
    transition: color 0.3s ease;
}

.login-link:hover {
    color: var(--color-dorado);
    text-decoration: underline;
}

/* Input date personalizado */
input[type="date"].form-control {
    color: var(--color-gris-oscuro) !important;
    background: var(--color-blanco) !important;
    border: 2px solid var(--color-gris-medio) !important;
    border-radius: 8px !important;
    padding: 0.75rem !important;
}

input[type="date"].form-control:focus {
    border-color: var(--color-dorado) !important;
    box-shadow: 0 0 0 0.2rem rgba(212, 175, 55, 0.25) !important;
}

/* Responsive */
@media (max-width: 768px) {
    .register-glass {
        width: 90%;
        padding: 2rem;
        margin: 1rem;
    }
    
    .password-toggle {
        top: 65%;
        right: 10px;
    }
    
    .mb-3.row .col {
        margin-bottom: 1rem;
    }
    
    .register-glass h2 {
        font-size: 1.75rem;
    }
}

@media (max-width: 576px) {
    .register-glass {
        width: 95%;
        padding: 1.5rem;
    }
    
    .mb-3.row {
        flex-direction: column;
    }
    
    .mb-3.row .col {
        width: 100%;
    }
    
    .register-logo {
        max-width: 120px;
    }
}
</style>
@endpush

@push('js')
<script>
document.addEventListener("DOMContentLoaded", () => {
    // Validación de solo letras
    const soloLetras = document.querySelectorAll('input[name=nombre], input[name=apellido_paterno], input[name=apellido_materno]');
    soloLetras.forEach(input => {
        input.addEventListener("input", function() {
            this.value = this.value.replace(/[^A-Za-zÁÉÍÓÚáéíóúÑñ\s]/g, "");
        });
    });

    // Mostrar / ocultar contraseña
    // Robust password toggle: look up nearest input inside the same position-relative container
    document.querySelectorAll('.password-toggle').forEach(toggle => {
        toggle.setAttribute('role', 'button');
        toggle.setAttribute('tabindex', '0');
        const handler = () => {
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