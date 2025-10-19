@extends('adminlte::page')

@section('title', 'Agregar Barbero')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="mb-0"><i class="fas fa-user-plus text-gold"></i> Agregar Barbero</h1>
        <a href="{{ route('admin.barberos.index') }}" class="btn btn-outline-custom">
            <i class="fas fa-arrow-left"></i> Volver
        </a>
    </div>
@stop

@section('content')
<div class="container-fluid">
    <div class="card shadow-lg custom-card">
        <div class="card-header custom-card-header">
            <h3 class="card-title mb-0"><i class="fas fa-user-scissors mr-2"></i>Información del Barbero</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.barberos.store') }}" method="POST" enctype="multipart/form-data">
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
                                <i class="fas fa-envelope text-dorado mr-2"></i>Correo Electrónico
                            </label>
                            <input type="email" class="form-control custom-input @error('correo') is-invalid @enderror" 
                                   name="correo" value="{{ old('correo') }}" placeholder="correo@ejemplo.com">
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
                                   name="telefono" value="{{ old('telefono') }}" placeholder="Ej: 5512345678" 
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
                    <div class="custom-file-input-wrapper">
                        <input type="file" class="custom-file-input @error('imagen') is-invalid @enderror" 
                               name="imagen" accept="image/*" id="imagen">
                        <label for="imagen" class="custom-file-label">
                            <i class="fas fa-upload mr-2"></i>Seleccionar archivo
                        </label>
                        @error('imagen')
                            <div class="invalid-feedback custom-invalid d-block">{{ $message }}</div>
                        @enderror
                    </div>
                    <small class="form-text text-muted mt-2">
                        Formatos aceptados: JPG, PNG, GIF. Tamaño máximo: 2MB
                    </small>
                </div>

                {{-- Previsualización de imagen --}}
                <div class="form-group mb-4 d-none" id="image-preview-container">
                    <label class="form-label custom-label">Vista previa:</label>
                    <div class="image-preview-wrapper">
                        <img id="image-preview" class="img-preview" src="#" alt="Vista previa de la imagen">
                    </div>
                </div>

                <div class="text-center mt-4 pt-3 border-top">
                    <button type="submit" class="btn btn-custom btn-lg px-5">
                        <i class="fas fa-save mr-2"></i>Guardar Barbero
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
/* Estilos específicos para el formulario */
.custom-card {
    border: none;
    border-radius: 12px;
    background: var(--color-blanco);
    box-shadow: 0 6px 20px rgba(0,0,0,0.1);
    border-left: 4px solid var(--color-dorado);
}

.custom-card-header {
    background: linear-gradient(135deg, var(--color-negro) 0%, var(--color-gris-oscuro) 100%);
    color: var(--color-blanco);
    border-bottom: 3px solid var(--color-dorado);
    border-radius: 12px 12px 0 0;
    padding: 20px 25px;
}

.custom-card-header .card-title {
    font-weight: 600;
    font-size: 1.3rem;
}

.custom-label {
    font-weight: 600;
    color: var(--color-gris-oscuro);
    margin-bottom: 8px;
    font-size: 0.95rem;
}

.custom-input {
    border: 2px solid var(--color-beige-oscuro);
    border-radius: 8px;
    padding: 12px 15px;
    font-size: 0.95rem;
    transition: all 0.3s ease;
    background: var(--color-blanco);
}

.custom-input:focus {
    border-color: var(--color-dorado);
    box-shadow: 0 0 0 0.3rem rgba(212, 175, 55, 0.15);
    background: var(--color-blanco);
}

.custom-input::placeholder {
    color: #a0a0a0;
}

/* File input personalizado */
.custom-file-input-wrapper {
    position: relative;
}

.custom-file-input {
    position: absolute;
    opacity: 0;
    width: 100%;
    height: 100%;
    cursor: pointer;
}

.custom-file-label {
    display: block;
    padding: 12px 15px;
    border: 2px dashed var(--color-beige-oscuro);
    border-radius: 8px;
    background: var(--color-beige);
    text-align: center;
    cursor: pointer;
    transition: all 0.3s ease;
    color: var(--color-gris-medio);
    font-weight: 500;
}

.custom-file-label:hover {
    border-color: var(--color-dorado);
    background: var(--color-dorado-claro);
    color: var(--color-negro);
}

/* Previsualización de imagen */
.img-preview {
    width: 120px;
    height: 120px;
    border-radius: 8px;
    object-fit: cover;
    border: 3px solid var(--color-dorado);
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
}

.image-preview-wrapper {
    display: inline-block;
    padding: 10px;
    background: var(--color-beige);
    border-radius: 10px;
    border: 2px solid var(--color-beige-oscuro);
}

/* Botones */
.btn-custom {
    background: linear-gradient(135deg, var(--color-dorado) 0%, var(--color-dorado-claro) 100%);
    color: var(--color-negro);
    border: none;
    border-radius: 8px;
    padding: 12px 30px;
    font-weight: 600;
    font-size: 1rem;
    transition: all 0.3s ease;
    box-shadow: 0 4px 12px rgba(212, 175, 55, 0.3);
}

.btn-custom:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 16px rgba(212, 175, 55, 0.4);
    background: linear-gradient(135deg, var(--color-dorado-claro) 0%, var(--color-dorado) 100%);
    color: var(--color-negro);
}

.btn-outline-custom {
    border: 2px solid var(--color-dorado);
    color: var(--color-dorado);
    background: transparent;
    border-radius: 8px;
    padding: 12px 30px;
    font-weight: 600;
    font-size: 1rem;
    transition: all 0.3s ease;
}

.btn-outline-custom:hover {
    background: var(--color-dorado);
    color: var(--color-negro);
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(212, 175, 55, 0.3);
}

/* Validación */
.custom-invalid {
    color: #e74c3c;
    font-weight: 500;
    font-size: 0.85rem;
}

.form-control.is-invalid {
    border-color: #e74c3c;
    box-shadow: 0 0 0 0.2rem rgba(231, 76, 60, 0.15);
}

/* Responsive */
@media (max-width: 768px) {
    .custom-card-header .card-title {
        font-size: 1.1rem;
    }
    
    .btn-custom, .btn-outline-custom {
        padding: 10px 20px;
        font-size: 0.9rem;
        width: 100%;
        margin-bottom: 10px;
    }
    
    .img-preview {
        width: 100px;
        height: 100px;
    }
}
</style>
@endsection

@section('js')
<script>
    // Previsualización de imagen
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
            fileLabel.innerHTML = '<i class="fas fa-upload mr-2"></i>Seleccionar archivo';
            fileLabel.style.borderColor = '';
            fileLabel.style.background = '';
            fileLabel.style.color = '';
        }
    });
</script>
@endsection