@extends('adminlte::page')

@section('title', 'Editar Barbero')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="mb-0"><i class="fas fa-edit text-gold"></i> Editar Barbero</h1>
        <a href="{{ route('admin.barberos.index') }}" class="btn btn-outline-custom">
            <i class="fas fa-arrow-left"></i> Volver
        </a>
    </div>
@stop

@section('content')
<div class="container-fluid">
    <div class="card shadow-lg custom-card">
        <div class="card-header custom-card-header">
            <h3 class="card-title mb-0"><i class="fas fa-user-edit mr-2"></i>Editar Información del Barbero</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.barberos.update', $barbero->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                {{-- Nombre --}}
                <div class="form-group mb-4">
                    <label for="nombre" class="form-label custom-label">
                        <i class="fas fa-user text-dorado mr-2"></i>Nombre <span class="text-danger">*</span>
                    </label>
                    <input type="text" class="form-control custom-input @error('nombre') is-invalid @enderror" 
                           name="nombre" value="{{ old('nombre', $barbero->nombre) }}" placeholder="Ingresa el nombre" required>
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
                                   name="apellido_paterno" value="{{ old('apellido_paterno', $barbero->apellido_paterno) }}" 
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
                                   name="apellido_materno" value="{{ old('apellido_materno', $barbero->apellido_materno) }}" 
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
                                <i class="fas fa-envelope text-dorado mr-2"></i>Correo Electrónico
                            </label>
                            <input type="email" class="form-control custom-input @error('correo') is-invalid @enderror" 
                                   name="correo" value="{{ old('correo', $barbero->correo) }}" placeholder="correo@ejemplo.com">
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
                                   name="telefono" value="{{ old('telefono', $barbero->telefono) }}" placeholder="Ej: 5512345678"
                                   pattern="[0-9]{7,15}" title="Ingrese solo números, mínimo 7 dígitos">
                            @error('telefono')
                                <div class="invalid-feedback custom-invalid">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- Imagen --}}
                <div class="form-group mb-4">
                    <label for="imagen" class="form-label custom-label">
                        <i class="fas fa-camera text-dorado mr-2"></i>Imagen del Barbero
                    </label>
                    
                    {{-- Imagen actual --}}
                    @if($barbero->imagen)
                    <div class="current-image mb-3">
                        <label class="form-label custom-label text-success">
                            <i class="fas fa-image mr-2"></i>Imagen Actual:
                        </label>
                        <div class="current-image-wrapper">
                            <img src="{{ asset('storage/' . $barbero->imagen) }}" 
                                 class="img-current" 
                                 alt="Imagen actual de {{ $barbero->nombre_completo }}">
                            <div class="current-image-overlay">
                                <span class="badge badge-custom">Actual</span>
                            </div>
                        </div>
                    </div>
                    @endif

                    <div class="custom-file-input-wrapper">
                        <input type="file" class="custom-file-input @error('imagen') is-invalid @enderror" 
                               name="imagen" accept="image/*" id="imagen">
                        <label for="imagen" class="custom-file-label">
                            <i class="fas fa-sync-alt mr-2"></i>Cambiar imagen
                        </label>
                        @error('imagen')
                            <div class="invalid-feedback custom-invalid d-block">{{ $message }}</div>
                        @enderror
                    </div>
                    <small class="form-text text-muted mt-2">
                        Dejar en blanco para mantener la imagen actual. Formatos: JPG, PNG, GIF. Tamaño máximo: 2MB
                    </small>
                </div>

                {{-- Previsualización de nueva imagen --}}
                <div class="form-group mb-4 d-none" id="image-preview-container">
                    <label class="form-label custom-label text-info">
                        <i class="fas fa-eye mr-2"></i>Vista previa de la nueva imagen:
                    </label>
                    <div class="image-preview-wrapper">
                        <img id="image-preview" class="img-preview" src="#" alt="Vista previa de la nueva imagen">
                    </div>
                </div>

                <div class="text-center mt-4 pt-3 border-top">
                    <button type="submit" class="btn btn-custom btn-lg px-5">
                        <i class="fas fa-save mr-2"></i>Actualizar Barbero
                    </button>
                    <a href="{{ route('admin.barberos.index') }}" class="btn btn-outline-custom btn-lg px-5 ml-3">
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
/* Estilos específicos para edición */
.img-current {
    width: 120px;
    height: 120px;
    border-radius: 8px;
    object-fit: cover;
    border: 3px solid var(--color-dorado);
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
}

.current-image-wrapper {
    position: relative;
    display: inline-block;
    padding: 10px;
    background: var(--color-beige);
    border-radius: 10px;
    border: 2px solid var(--color-beige-oscuro);
}

.current-image-overlay {
    position: absolute;
    top: 5px;
    right: 5px;
}

.badge-custom {
    background: var(--color-dorado);
    color: var(--color-negro);
    font-weight: 600;
    font-size: 0.7rem;
    padding: 4px 8px;
}

/* Efectos para la imagen actual */
.current-image-wrapper:hover .img-current {
    transform: scale(1.05);
    transition: transform 0.3s ease;
}

/* Estados de los inputs para edición */
.custom-input:not(:placeholder-shown) {
    background: linear-gradient(135deg, #f8fff8 0%, var(--color-blanco) 100%);
    border-left: 3px solid var(--color-dorado);
}
</style>
@endsection

@section('js')
<script>
    // Previsualización de imagen para edición
    document.getElementById('imagen').addEventListener('change', function(e) {
        const file = e.target.files[0];
        const previewContainer = document.getElementById('image-preview-container');
        const preview = document.getElementById('image-preview');
        const fileLabel = document.querySelector('.custom-file-label');
        
        if (file) {
            const reader = new FileReader();
            
            reader.onload = function(e) {
                preview.src = e.target.result;
                previewContainer.classList.remove('d-none');
            }
            
            reader.readAsDataURL(file);
            fileLabel.innerHTML = `<i class="fas fa-check mr-2"></i>${file.name}`;
            fileLabel.style.borderColor = 'var(--color-dorado)';
            fileLabel.style.background = 'var(--color-dorado-claro)';
            fileLabel.style.color = 'var(--color-negro)';
        } else {
            previewContainer.classList.add('d-none');
            fileLabel.innerHTML = '<i class="fas fa-sync-alt mr-2"></i>Cambiar imagen';
            fileLabel.style.borderColor = '';
            fileLabel.style.background = '';
            fileLabel.style.color = '';
        }
    });

    // Efecto para mostrar qué campos han sido modificados
    document.querySelectorAll('.custom-input').forEach(input => {
        const originalValue = input.value;
        
        input.addEventListener('input', function() {
            if (this.value !== originalValue) {
                this.style.background = 'linear-gradient(135deg, #fff8e1 0%, var(--color-blanco) 100%)';
                this.style.borderLeft = '3px solid var(--color-dorado)';
            } else {
                this.style.background = '';
                this.style.borderLeft = '';
            }
        });
    });
</script>
@endsection