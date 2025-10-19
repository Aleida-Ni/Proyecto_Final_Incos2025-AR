@extends('adminlte::page')

@section('title', 'Registrar Empleado')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="mb-0"><i class="fas fa-user-plus text-gold"></i> Registrar Nuevo Empleado</h1>
        <a href="{{ route('admin.empleados.index') }}" class="btn btn-outline-custom">
            <i class="fas fa-arrow-left mr-2"></i>Volver
        </a>
    </div>
@stop

@section('content')
<div class="container-fluid">
    <div class="card shadow-lg custom-card">
        <div class="card-header custom-card-header">
            <h3 class="card-title mb-0"><i class="fas fa-user-tie mr-2"></i>Información del Empleado</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.empleados.store') }}" method="POST">
                @csrf

                {{-- Nombre --}}
                <div class="form-group mb-4">
                    <label for="nombre" class="form-label custom-label">
                        <i class="fas fa-user text-dorado mr-2"></i>Nombre <span class="text-danger">*</span>
                    </label>
                    <input type="text" class="form-control custom-input @error('nombre') is-invalid @enderror" 
                           name="nombre" value="{{ old('nombre') }}" placeholder="Ingresa el nombre" required>
                    @error('nombre')
                        <div class="invalid-feedback custom-invalid">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Apellidos --}}
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-4">
                            <label for="apellido_paterno" class="form-label custom-label">
                                <i class="fas fa-user-tag text-dorado mr-2"></i>Primer Apellido <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control custom-input @error('apellido_paterno') is-invalid @enderror" 
                                   name="apellido_paterno" value="{{ old('apellido_paterno') }}" placeholder="Apellido paterno" required>
                            @error('apellido_paterno')
                                <div class="invalid-feedback custom-invalid">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-4">
                            <label for="apellido_materno" class="form-label custom-label">
                                <i class="fas fa-user-tag text-dorado mr-2"></i>Segundo Apellido <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control custom-input @error('apellido_materno') is-invalid @enderror" 
                                   name="apellido_materno" value="{{ old('apellido_materno') }}" placeholder="Apellido materno" required>
                            @error('apellido_materno')
                                <div class="invalid-feedback custom-invalid">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- Correo y Teléfono --}}
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-4">
                            <label for="correo" class="form-label custom-label">
                                <i class="fas fa-envelope text-dorado mr-2"></i>Correo Electrónico <span class="text-danger">*</span>
                            </label>
                            <input type="email" class="form-control custom-input @error('correo') is-invalid @enderror" 
                                   name="correo" value="{{ old('correo') }}" placeholder="correo@ejemplo.com" required>
                            @error('correo')
                                <div class="invalid-feedback custom-invalid">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-4">
                            <label for="telefono" class="form-label custom-label">
                                <i class="fas fa-phone text-dorado mr-2"></i>Teléfono
                            </label>
                            <input type="text" class="form-control custom-input @error('telefono') is-invalid @enderror" 
                                   name="telefono" value="{{ old('telefono') }}" placeholder="Ej: 5512345678">
                            @error('telefono')
                                <div class="invalid-feedback custom-invalid">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- Fecha de Nacimiento --}}
                <div class="form-group mb-4">
                    <label for="fecha_nacimiento" class="form-label custom-label">
                        <i class="fas fa-birthday-cake text-dorado mr-2"></i>Fecha de Nacimiento
                    </label>
                    <input type="date" class="form-control custom-input @error('fecha_nacimiento') is-invalid @enderror" 
                           name="fecha_nacimiento" value="{{ old('fecha_nacimiento') }}">
                    @error('fecha_nacimiento')
                        <div class="invalid-feedback custom-invalid">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Información de contraseña --}}
                <div class="alert alert-info alert-custom mb-4">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-info-circle fa-2x mr-3 text-info"></i>
                        <div>
                            <h5 class="alert-heading mb-1">Información importante</h5>
                            <p class="mb-0">La contraseña será generada automáticamente y enviada al correo electrónico del empleado.</p>
                        </div>
                    </div>
                </div>

                <div class="text-center mt-4 pt-3 border-top">
                    <button type="submit" class="btn btn-custom btn-lg px-5">
                        <i class="fas fa-save mr-2"></i>Registrar Empleado
                    </button>
                    <a href="{{ route('admin.empleados.index') }}" class="btn btn-outline-custom btn-lg px-5 ml-3">
                        <i class="fas fa-times mr-2"></i>Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('css')
<style>
/* Estilos específicos para el formulario de empleados */
.alert-info {
    background: linear-gradient(135deg, #d1ecf1 0%, #bee5eb 100%);
    color: #0c5460;
    border-left: 4px solid #17a2b8;
    border-radius: 8px;
}

.alert-info .alert-heading {
    color: #0c5460;
    font-weight: 600;
}
</style>
@endsection