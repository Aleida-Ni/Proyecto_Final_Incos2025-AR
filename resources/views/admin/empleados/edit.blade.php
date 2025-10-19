@extends('adminlte::page')

@section('title', 'Editar Empleado')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="mb-0"><i class="fas fa-user-edit text-gold"></i> Editar Empleado</h1>
        <a href="{{ route('admin.empleados.index') }}" class="btn btn-outline-custom">
            <i class="fas fa-arrow-left mr-2"></i>Volver
        </a>
    </div>
@stop

@section('content')
<div class="container-fluid">
    <div class="card shadow-lg custom-card">
        <div class="card-header custom-card-header">
            <h3 class="card-title mb-0"><i class="fas fa-user-edit mr-2"></i>Editar Información del Empleado</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.empleados.update', $empleado->id) }}" method="POST">
                @csrf
                @method('PUT')

                {{-- Información del empleado --}}
                <div class="row mb-4">
                    <div class="col-12">
                        <div class="employee-info bg-beige p-3 rounded">
                            <h6 class="text-gris-oscuro mb-2">
                                <i class="fas fa-user-circle text-dorado mr-2"></i>
                                Editando: <strong>{{ $empleado->nombre }} {{ $empleado->apellido_paterno }} {{ $empleado->apellido_materno }}</strong>
                            </h6>
                            <small class="text-gris-medio">
                                <i class="fas fa-envelope mr-1"></i>{{ $empleado->correo }}
                                @if($empleado->telefono)
                                    • <i class="fas fa-phone ml-2 mr-1"></i>{{ $empleado->telefono }}
                                @endif
                            </small>
                        </div>
                    </div>
                </div>

                {{-- Nombre --}}
                <div class="form-group mb-4">
                    <label for="nombre" class="form-label custom-label">
                        <i class="fas fa-user text-dorado mr-2"></i>Nombre <span class="text-danger">*</span>
                    </label>
                    <input type="text" class="form-control custom-input @error('nombre') is-invalid @enderror" 
                           name="nombre" value="{{ old('nombre', $empleado->nombre) }}" placeholder="Ingresa el nombre" required>
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
                                   name="apellido_paterno" value="{{ old('apellido_paterno', $empleado->apellido_paterno) }}" 
                                   placeholder="Apellido paterno" required>
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
                                   name="apellido_materno" value="{{ old('apellido_materno', $empleado->apellido_materno) }}" 
                                   placeholder="Apellido materno" required>
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
                                   name="correo" value="{{ old('correo', $empleado->correo) }}" placeholder="correo@ejemplo.com" required>
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
                                   name="telefono" value="{{ old('telefono', $empleado->telefono) }}" placeholder="Ej: 5512345678">
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
                           name="fecha_nacimiento" value="{{ old('fecha_nacimiento', $empleado->fecha_nacimiento) }}">
                    @error('fecha_nacimiento')
                        <div class="invalid-feedback custom-invalid">{{ $message }}</div>
                    @enderror
                </div>

                <div class="text-center mt-4 pt-3 border-top">
                    <button type="submit" class="btn btn-custom btn-lg px-5">
                        <i class="fas fa-save mr-2"></i>Actualizar Empleado
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
/* Estilos específicos para edición de empleados */
.employee-info {
    border-left: 4px solid var(--color-dorado);
    background: linear-gradient(135deg, var(--color-beige) 0%, var(--color-beige-oscuro) 100%);
}

/* Indicador visual de campos modificados */
.custom-input.modified {
    background: linear-gradient(135deg, #fff8e1 0%, var(--color-blanco) 100%);
    border-left: 3px solid var(--color-dorado);
}
</style>
@endsection

@section('js')
<script>
    // Efecto para mostrar campos modificados
    document.addEventListener('DOMContentLoaded', function() {
        const inputs = document.querySelectorAll('.custom-input');
        
        inputs.forEach(input => {
            const originalValue = input.value;
            
            input.addEventListener('input', function() {
                if (this.value !== originalValue) {
                    this.classList.add('modified');
                } else {
                    this.classList.remove('modified');
                }
            });
        });
    });
</script>
@endsection