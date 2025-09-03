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

            <button type="submit" class="btn btn-success">💾 Guardar</button>
            <a href="{{ route('admin.empleados.index') }}" class="btn btn-secondary">↩ Volver</a>
        </form>
    </div>
@stop
