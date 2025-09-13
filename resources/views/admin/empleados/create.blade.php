@extends('adminlte::page')

@section('title', 'Registrar Empleado')

@section('content_header')
    <h1 class="text-center text-primary" style="text-shadow: 0 0 5px #00aaff, 0 0 10px #00ccff;">Registrar Nuevo Empleado</h1>
@stop

@section('content')
    <div class="container">
        <a href="{{ route('admin.empleados.index') }}" class="btn btn-secondary mb-3">⬅ Volver</a>

        <form action="{{ route('admin.empleados.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label>Nombre</label>
                <input type="text" name="name" class="form-control" required>
            </div>

            <div class="form-group">
                <label>Correo Electrónico</label>
                <input type="email" name="email" class="form-control" required>
            </div>

        <div class="form-group mb-3">
            <label class="text-white">Teléfono</label>
            <input type="text" name="telefono" class="form-control border-secondary bg-dark text-white" placeholder="Ingrese su teléfono">
        </div>

            <div class="form-group">
                <label>Fecha de Nacimiento</label>
                <input type="date" name="fecha_nacimiento" class="form-control">
            </div>

            <div class="form-group">
                <label>Contraseña</label>
                <input type="password" name="password" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-success">💾 Guardar</button>
        </form>
    </div>
@stop
