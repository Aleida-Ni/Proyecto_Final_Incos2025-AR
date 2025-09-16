@extends('adminlte::page')

@section('title', 'Registrar Empleado')

@section('content_header')
<h1 class="text-center text-primary" style="text-shadow: 0 0 5px #00aaff, 0 0 10px #00ccff;">Registrar Nuevo Empleado</h1>
@stop

@section('content')
<div class="container mt-4">
    <a href="{{ route('admin.empleados.index') }}" 
       class="btn btn-secondary mb-4 px-4"
       style="border-radius: 25px; font-weight:700; box-shadow: 0 4px 10px rgba(100,100,100,0.5);">
       ⬅ Volver
    </a>

    <form action="{{ route('admin.empleados.store') }}" method="POST" class="p-4" style="background-color: #111; border-radius: 15px; box-shadow: 0 4px 20px rgba(0,170,255,0.3);">
        @csrf

        <div class="form-group mb-3">
            <label class="text-white">Nombre</label>
            <input type="text" name="nombre" class="form-control border-secondary bg-dark text-white" placeholder="Ingrese el nombre" required>
        </div>

        <div class="form-group mb-3">
            <label class="text-white">Apellido Paterno</label>
            <input type="text" name="apellido_paterno" class="form-control border-secondary bg-dark text-white" placeholder="Ingrese el apellido paterno" required>
        </div>

        <div class="form-group mb-3">
            <label class="text-white">Apellido Materno</label>
            <input type="text" name="apellido_materno" class="form-control border-secondary bg-dark text-white" placeholder="Ingrese el apellido materno" required>
        </div>

        <div class="form-group mb-3">
            <label class="text-white">Correo Electrónico</label>
            <input type="email" name="correo" class="form-control border-secondary bg-dark text-white" placeholder="ejemplo@correo.com" required>
        </div>

        <div class="form-group mb-3">
            <label class="text-white">Teléfono</label>
            <input type="text" name="telefono" class="form-control border-secondary bg-dark text-white" placeholder="Ingrese su teléfono">
        </div>

        <div class="form-group mb-3">
            <label class="text-white">Fecha de Nacimiento</label>
            <input type="date" name="fecha_nacimiento" class="form-control border-secondary bg-dark text-white">
        </div>

        <p class="text-white">La contraseña será generada automáticamente y enviada al correo del empleado.</p>

        <button type="submit" class="btn btn-gradient-success btn-lg w-100"
            style="background: linear-gradient(135deg, #00ff99, #00cc66); color:#111; font-weight:700; border-radius:25px; box-shadow:0 4px 15px rgba(0,255,170,0.5); transition:0.3s;">
            💾 Guardar
        </button>
    </form>
</div>
@stop
