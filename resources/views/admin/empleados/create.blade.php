@extends('adminlte::page')

@section('title', 'Registrar Empleado')

@section('content_header')
    <h1 class="text-center">Registrar Nuevo Empleado</h1>
@stop

@section('content')
    <div class="container">
        <form action="{{ route('admin.empleados.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label>Nombre</label>
                <input type="text" name="nombre" class="form-control" required>
            </div>

            <div class="form-group">
                <label>Apellido Paterno</label>
                <input type="text" name="apellido_paterno" class="form-control" required>
            </div>

            <div class="form-group">
                <label>Apellido Materno</label>
                <input type="text" name="apellido_materno" class="form-control" required>
            </div>

            <div class="form-group">
                <label>Correo</label>
                <input type="email" name="correo" class="form-control" required>
            </div>

            <div class="form-group">
                <label>Teléfono</label>
                <input type="text" name="telefono" class="form-control">
            </div>

            <div class="form-group">
                <label>Fecha de Nacimiento</label>
                <input type="date" name="fecha_nacimiento" class="form-control">
            </div>

            <div class="form-group">
                <label>Contraseña</label>
                <div class="input-group">
                    <input type="password" name="contraseña" id="contraseña" class="form-control" required>
                    <div class="input-group-append">
                        <span class="input-group-text">
                            <i id="toggleContraseña" class="fa fa-eye"></i>
                        </span>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-success">💾 Guardar</button>
            <a href="{{ route('admin.empleados.index') }}" class="btn btn-secondary">↩ Volver</a>
        </form>
    </div>
@stop

@section('js')
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
</script>
@stop
