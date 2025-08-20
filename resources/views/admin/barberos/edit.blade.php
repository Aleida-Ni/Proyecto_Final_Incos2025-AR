@extends('adminlte::page')

@section('title', 'Editar Barbero')

@section('content')
    <h1 class="text-dark">Editar Barbero</h1>
    <form action="{{ route('admin.barberos.update', $barbero->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        {{-- Nombre --}}
        <div class="mb-3">
            <label for="nombre" class="form-label text-dark">Nombre</label>
            <input type="text" class="form-control border-secondary" name="nombre" value="{{ $barbero->nombre }}" required>
        </div>

        {{-- Apellidos en una sola fila --}}
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="apellido_paterno" class="form-label text-dark">Apellido Paterno</label>
                <input type="text" class="form-control border-secondary" name="apellido_paterno" value="{{ $barbero->apellido_paterno }}" required>
            </div>
            <div class="col-md-6 mb-3">
                <label for="apellido_materno" class="form-label text-dark">Apellido Materno</label>
                <input type="text" class="form-control border-secondary" name="apellido_materno" value="{{ $barbero->apellido_materno }}" required>
            </div>
        </div>

        {{-- Correo y Teléfono en una sola fila --}}
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="correo" class="form-label text-dark">Correo</label>
                <input type="email" class="form-control border-secondary" name="correo" value="{{ $barbero->correo }}">
            </div>
            <div class="col-md-6 mb-3">
                <label for="telefono" class="form-label text-dark">Teléfono</label>
                <input type="text" class="form-control border-secondary" name="telefono" value="{{ $barbero->telefono }}">
            </div>
        </div>

        {{-- Cargo --}}
        <div class="mb-3">
            <label for="cargo" class="form-label text-dark">Cargo</label>
            <input type="text" class="form-control border-secondary" name="cargo" value="{{ $barbero->cargo }}" required>
        </div>

        {{-- Imagen --}}
        <div class="mb-3">
            <label for="imagen" class="form-label text-dark">Imagen</label>
            <input type="file" class="form-control border-secondary" name="imagen">
            @if($barbero->imagen)
                <img src="{{ asset('storage/' . $barbero->imagen) }}" width="80" class="mt-2">
            @endif
        </div>

        <button type="submit" class="btn btn-primary">Actualizar</button>
    </form>
@endsection
