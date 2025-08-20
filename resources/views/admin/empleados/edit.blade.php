@extends('adminlte::page')

@section('title', 'Editar Empleado')

@section('content_header')
    <h1 class="text-center">Editar Empleado</h1>
@stop

@section('content')
    <div class="container">
        <a href="{{ route('admin.empleados.index') }}" class="btn btn-secondary mb-3">⬅ Volver</a>

        <form action="{{ route('admin.empleados.update', $empleado->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label>Nombre</label>
                <input type="text" name="name" value="{{ $empleado->name }}" class="form-control" required>
            </div>

            <div class="form-group">
                <label>Correo Electrónico</label>
                <input type="email" name="email" value="{{ $empleado->email }}" class="form-control" required>
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
                <label>Contraseña (dejar vacío si no deseas cambiarla)</label>
                <input type="password" name="password" class="form-control">
            </div>

            <button type="submit" class="btn btn-primary">💾 Actualizar</button>
        </form>
    </div>
@stop
