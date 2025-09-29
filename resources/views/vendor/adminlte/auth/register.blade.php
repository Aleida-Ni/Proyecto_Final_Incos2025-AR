@extends('adminlte::auth.auth-page', ['auth_type' => 'register'])

@section('title', 'Registrarse')

@section('auth_header', '')

@section('auth_body')
<div class="register-wrapper">
    <div class="register-glass">

        <h2 class="mb-4 text-center">Registro</h2>

        <form action="{{ route('register') }}" method="post" autocomplete="off" id="registerForm">
            @csrf

            <div class="mb-3">
                <x-adminlte-input name="nombre" type="text" placeholder="Tu nombre"
                    pattern="^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]{2,30}$"
                    maxlength="30"
                    title="Solo se permiten letras y espacios (2 a 30 caracteres)"
                    required autofocus icon="fas fa-user" />
            </div>

            <div class="mb-3 row">
                <div class="col">
                    <x-adminlte-input name="apellido_paterno" type="text" placeholder="Primer Apellido"
                        pattern="^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]{2,30}$"
                        maxlength="30"
                        title="Solo se permiten letras y espacios (2 a 30 caracteres)"
                        required icon="fas fa-user" />
                </div>
                <div class="col">
                    <x-adminlte-input name="apellido_materno" type="text" placeholder="Segundo Apellido"
                        pattern="^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]{2,30}$"
                        maxlength="30"
                        title="Solo se permiten letras y espacios (2 a 30 caracteres)"
                        required icon="fas fa-user" />
                </div>
            </div>

            <div class="mb-3 row">
                <div class="col">
                    <x-adminlte-input name="correo" type="email" placeholder="correo@ejemplo.com" required icon="fas fa-envelope" />
                </div>
                <div class="col">
                    <x-adminlte-input name="telefono" type="tel" placeholder="Ej: 76543210"
                        pattern="[0-9]{8,10}"
                        title="Debe contener entre 8 y 10 dígitos numéricos"
                        required icon="fas fa-phone" />
                </div>
            </div>

            <div class="mb-3">
                <x-adminlte-input name="fecha_nacimiento" type="date" required icon="fas fa-calendar-alt" />
            </div>

            <div class="mb-3 row">
                <div class="col position-relative">
                    <x-adminlte-input id="contrasenia" name="contrasenia" type="password"
                        placeholder="*******"
                        pattern="(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}"
                        title="Mínimo 8 caracteres, con letras y números"
                        required icon="fas fa-lock" />
                    <span class="password-toggle"><i class="fas fa-eye" id="toggleContrasenia"></i></span>
                </div>
                <div class="col position-relative">
                    <x-adminlte-input id="contrasenia_confirmation" name="contrasenia_confirmation" type="password"
                        placeholder="*******" required icon="fas fa-lock" />
                    <span class="password-toggle"><i class="fas fa-eye" id="toggleContraseniaConfirm"></i></span>
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
    background: url("{{ asset('imagenes/servicios/login-register.png') }}") no-repeat center center fixed !important;
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

.register-glass {
    background: rgba(255, 255, 255, 0.1);
    border-radius: 20px;
    padding: 2rem;
    width: 100%;
    max-width: 700px; 
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.4);
    backdrop-filter: blur(12px) saturate(180%);
    -webkit-backdrop-filter: blur(12px) saturate(180%);
    border: 1px solid rgba(255, 255, 255, 0.2);
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
    top: 50%; 
    right: 12px;
    transform: translateY(-50%);
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
    background: rgba(255, 255, 255, 0.15);
    border: none;
    color: white;
}

/* Links negros */
.login-link {
    color: black;
    font-size: 0.9rem;
    font-weight: 500;
    text-decoration: none;
}
.login-link:hover { color: #333; }

/* Responsive */
@media (max-width: 768px) {
    .register-glass { width: 90%; padding: 1.5rem; }
    .password-toggle { top: 50%; right: 8px; transform: translateY(-50%); }
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
