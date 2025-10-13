@extends('adminlte::auth.auth-page', ['auth_type' => 'register'])
@section('title', 'Registrarse')
@section('auth_header', '')
@section('auth_body')
<div class="register-wrapper">
    <div class="register-glass">
        <h2 class="mb-4 text-center">Registrarse</h2>
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
            <div class="mb-3 row">
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
            <div class="mb-3 row">
                <div class="col text-start">
                    <label class="form-label">Correo</label>
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
            <div class="mb-3 row">
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

            <button type="submit" class="btn btn-block custom-btn mt-2 mb-3">Registrarse</button>
        </form>

        <div class="text-center">
            <a href="{{ route('login') }}" class="login-link">¿Ya tienes una cuenta? Inicia sesión</a>
        </div>
    </div>
</div>
@endsection

@push('css')
<style>
html, body, .auth-page {
    height: 100%;
    margin: 0;
    padding: 0;
    background: #c8c6c68b !important;
    background-size: cover !important;
    font-family: 'Nunito', sans-serif;
}

/* Anula fondo blanco */
.login-box, .login-box .card, .login-box .card-body, .login-box .card-header {
    background: transparent !important;
    box-shadow: none !important;
    border: none !important;
}

.register-wrapper {
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
    width: 100%;
    padding: 1rem;
}
.login-box {
    width: 100% !important;
    max-width: 100% !important;
}
.register-glass {
    background: rgba(245, 245, 245, 0.7);
    border-radius: 12px;
    padding: 2rem;
    width: 40%;
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
    backdrop-filter: blur(12px) saturate(180%);
    -webkit-backdrop-filter: blur(12px) saturate(180%);
    border: 1px solid rgba(0, 0, 0, 0.1);
    text-align: initial;
    transform: translateY(-80px);
}

/* Título */
.register-glass h2 {
    font-weight: bold;
    color: #111;
}

/* Inputs personalizados con bordes mejorados */
.custom-input .form-control {
    border: 1.5px solid #000 !important;
    border-radius: 6px !important;
    background: rgba(255, 255, 255, 0.9) !important;
    color: #000 !important;
    padding: 0.5rem 0.75rem !important;
    transition: all 0.3s ease !important;
}

.custom-input .form-control:focus {
    border-color: #2563eb !important;
    box-shadow: 0 0 0 0.2rem rgba(37, 99, 235, 0.25) !important;
    background: rgba(255, 255, 255, 1) !important;
}

.custom-input .input-group-text {
    border: 1.5px solid #000 !important;
    border-right: none !important;
    background: rgba(0, 0, 0, 0.05) !important;
    color: #000 !important;
    border-radius: 6px 0 0 6px !important;
}

.custom-input .form-control:focus + .input-group-text,
.custom-input:focus-within .input-group-text {
    border-color: #2563eb !important;
    background: rgba(37, 99, 235, 0.1) !important;
}

/* Botón mostrar/ocultar contraseña */
.position-relative {
    position: relative;
}
.password-toggle {
    position: absolute;
    top: 65%;
    right: 12px;
    transform: translateY(-50%);
    cursor: pointer;
    color: #666;
    font-size: 1.1rem;
    z-index: 5;
    background: rgba(255, 255, 255, 0.9);
    padding: 4px 8px;
    border-radius: 4px;
}
.password-toggle:hover {
    color: #000;
    background: rgba(255, 255, 255, 1);
}

/* Labels */
.form-label {
    font-size: 0.9rem;
    font-weight: 600;
    color: #333;
    margin-bottom: 0.4rem;
}

/* Botón negro cuadrado */
.custom-btn {
    background: #000;
    color: #fff;
    border: none;
    border-radius: 6px;
    padding: 0.6rem;
    font-weight: bold;
    text-transform: uppercase;
    transition: 0.3s ease;
    width: 100%;
}
.custom-btn:hover {
    background: linear-gradient(135deg, #2563eb, #0891b2);
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
}

/* Links negros */
.login-link {
    color: black;
    font-size: 0.9rem;
    font-weight: 500;
    text-decoration: none;
}
.login-link:hover {
    color: #333;
    text-decoration: underline;
}

/* Input date personalizado */
input[type="date"].form-control {
    color: #000 !important;
    background: rgba(255, 255, 255, 0.9) !important;
    border: 1.5px solid #000 !important;
    border-radius: 6px !important;
    padding: 0.5rem 0.75rem !important;
}

input[type="date"].form-control:focus {
    border-color: #2563eb !important;
    box-shadow: 0 0 0 0.2rem rgba(37, 99, 235, 0.25) !important;
    background: rgba(255, 255, 255, 1) !important;
}

/* Responsive */
@media (max-width: 768px) {
    .register-glass {
        width: 90%;
        padding: 1.5rem;
        transform: translateY(-40px);
    }
    
    .password-toggle {
        top: 62%;
        right: 8px;
    }
    
    .mb-3.row .col {
        margin-bottom: 1rem;
    }
}

@media (max-width: 576px) {
    .register-glass {
        width: 95%;
        padding: 1rem;
    }
    
    .mb-3.row {
        flex-direction: column;
    }
    
    .mb-3.row .col {
        width: 100%;
    }
}
</style>
@endpush

@push('js')
<script>
document.addEventListener("DOMContentLoaded", () => {
    const soloLetras = document.querySelectorAll('input[name=nombre], input[name=apellido_paterno], input[name=apellido_materno]');
    soloLetras.forEach(input => {
        input.addEventListener("input", function() {
            this.value = this.value.replace(/[^A-Za-zÁÉÍÓÚáéíóúÑñ\s]/g, "");
        });
    });

    // Mostrar / ocultar contraseña
    function togglePassword(inputId, toggleId) {
        const input = document.getElementById(inputId);
        const toggle = document.getElementById(toggleId);
        if (input && toggle) {
            toggle.addEventListener("click", () => {
                input.type = input.type === "password" ? "text" : "password";
                toggle.classList.toggle("fa-eye");
                toggle.classList.toggle("fa-eye-slash");
            });
        }
    }

    togglePassword("contrasenia", "toggleContrasenia");
    togglePassword("contrasenia_confirmation", "toggleContraseniaConfirm");
});
</script>
@endpush