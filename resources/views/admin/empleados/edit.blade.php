@extends('adminlte::page')

@section('title', 'Editar Empleado')

@section('content_header')
    <h1 class="text-center">Editar Empleado</h1>
@stop

@section('content')
    <div class="container">
        <form action="{{ route('admin.empleados.update', $empleado->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label>Nombre</label>
                <input type="text" name="nombre" value="{{ $empleado->nombre }}" class="form-control" required>
            </div>

            <div class="form-group">
                <label>Apellido Paterno</label>
                <input type="text" name="apellido_paterno" value="{{ $empleado->apellido_paterno }}" class="form-control" required>
            </div>

            <div class="form-group">
                <label>Apellido Materno</label>
                <input type="text" name="apellido_materno" value="{{ $empleado->apellido_materno }}" class="form-control" required>
            </div>

            <div class="form-group">
                <label>Correo</label>
                <input type="email" name="correo" value="{{ $empleado->correo }}" class="form-control" required>
            </div>

            <div class="form-group">
                <label>Teléfono</label>
                <input type="text" name="telefono" value="{{ $empleado->telefono }}" class="form-control">
            </div>

            <div class="form-group">
                <label>Fecha de Nacimiento</label>
                <input type="date" name="fecha_nacimiento" value="{{ $empleado->fecha_nacimiento }}" class="form-control">
            </div>

            <div class="form-group">
                <label>Nueva Contraseña (opcional)</label>
                <div class="input-group">
                    <input type="password" name="contraseña" id="contraseñaEdit" class="form-control">
                    <div class="input-group-append">
                        <span class="input-group-text">
                            <i id="toggleContraseñaEdit" class="fa fa-eye"></i>
                        </span>
                    </div>
                </div>
                <small class="text-muted">Déjalo vacío si no deseas cambiar la contraseña</small>
            </div>

            <button type="submit" class="btn btn-primary">💾 Actualizar</button>
            <a href="{{ route('admin.empleados.index') }}" class="btn btn-secondary">↩ Volver</a>
        </form>
    </div>
@stop

@section('js')
<script>
    togglePassword('toggleContraseñaEdit', 'contraseñaEdit');
</script>
@stop
