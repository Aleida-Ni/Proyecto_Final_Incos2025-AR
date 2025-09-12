@extends('adminlte::page')

@section('title', 'Agregar Barbero')

@section('content')
<div class="container mt-4">
    <div class="card shadow-lg border-primary">
        <div class="card-header bg-primary text-white">
            <h3 class="card-title">Agregar Barbero</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.barberos.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                {{-- Nombre --}}
                <div class="mb-3">
                    <label for="nombre" class="form-label">Nombre <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('nombre') is-invalid @enderror" 
                           name="nombre" value="{{ old('nombre') }}" required>
                    @error('nombre')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Apellidos --}}
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="apellido_paterno" class="form-label">Apellido Paterno <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('apellido_paterno') is-invalid @enderror" 
                               name="apellido_paterno" value="{{ old('apellido_paterno') }}" required>
                        @error('apellido_paterno')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="apellido_materno" class="form-label">Apellido Materno <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('apellido_materno') is-invalid @enderror" 
                               name="apellido_materno" value="{{ old('apellido_materno') }}" required>
                        @error('apellido_materno')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- Correo y Teléfono --}}
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="correo" class="form-label">Correo</label>
                        <input type="email" class="form-control @error('correo') is-invalid @enderror" 
                               name="correo" value="{{ old('correo') }}">
                        @error('correo')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="telefono" class="form-label">Teléfono</label>
                        <input type="text" class="form-control @error('telefono') is-invalid @enderror" 
                               name="telefono" value="{{ old('telefono') }}" pattern="[0-9]{7,15}" 
                               title="Ingrese solo números, mínimo 7 dígitos">
                        @error('telefono')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- Cargo --}}
                <div class="mb-3">
                    <label for="cargo" class="form-label">Cargo <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('cargo') is-invalid @enderror" 
                           name="cargo" value="{{ old('cargo') }}" required>
                    @error('cargo')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Imagen --}}
                <div class="mb-3">
                    <label for="imagen" class="form-label">Imagen</label>
                    <input type="file" class="form-control @error('imagen') is-invalid @enderror" 
                           name="imagen" accept="image/*">
                    @error('imagen')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="text-center">
                    <button type="submit" class="btn btn-primary btn-lg px-5">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
