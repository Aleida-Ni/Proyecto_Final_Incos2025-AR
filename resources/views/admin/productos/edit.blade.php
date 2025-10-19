@extends('adminlte::page')

@section('title', 'Editar Producto')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="mb-0"><i class="fas fa-edit text-gold"></i> Editar Producto</h1>
        <a href="{{ route('admin.productos.index') }}" class="btn btn-outline-custom">
            <i class="fas fa-arrow-left mr-2"></i>Volver
        </a>
    </div>
@stop

@section('content')
<div class="container-fluid">
    <div class="card shadow-lg custom-card">
        <div class="card-header custom-card-header">
            <h3 class="card-title mb-0"><i class="fas fa-box-edit mr-2"></i>Editar Información del Producto</h3>
        </div>
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger alert-custom">
                    <i class="fas fa-exclamation-triangle mr-2"></i>
                    <strong>Por favor corrige los siguientes errores:</strong>
                    <ul class="mb-0 mt-2">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.productos.update', $producto->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                {{-- Información del producto --}}
                <div class="row mb-4">
                    <div class="col-12">
                        <div class="product-info bg-beige p-3 rounded">
                            <div class="row align-items-center">
                                @if($producto->imagen)
                                <div class="col-auto">
                                    <img src="{{ asset('storage/' . $producto->imagen) }}" 
                                         class="img-current-product"
                                         alt="{{ $producto->nombre }}">
                                </div>
                                @endif
                                <div class="col">
                                    <h6 class="text-gris-oscuro mb-1">
                                        <i class="fas fa-box text-dorado mr-2"></i>
                                        Editando: <strong>{{ $producto->nombre }}</strong>
                                    </h6>
                                    <small class="text-gris-medio">
                                        <i class="fas fa-tag mr-1"></i>{{ $producto->categoria->nombre }} • 
                                        <i class="fas fa-dollar-sign mr-1"></i>{{ number_format($producto->precio, 2) }} Bs • 
                                        <i class="fas fa-boxes mr-1"></i>Stock: {{ $producto->stock }}
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        {{-- Nombre --}}
                        <div class="form-group mb-4">
                            <label for="nombre" class="form-label custom-label">
                                <i class="fas fa-tag text-dorado mr-2"></i>Nombre del Producto <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control custom-input @error('nombre') is-invalid @enderror" 
                                   name="nombre" value="{{ old('nombre', $producto->nombre) }}" required>
                            @error('nombre')
                                <div class="invalid-feedback custom-invalid">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Categoría --}}
                        <div class="form-group mb-4">
                            <label for="categoria_id" class="form-label custom-label">
                                <i class="fas fa-list-alt text-dorado mr-2"></i>Categoría <span class="text-danger">*</span>
                            </label>
                            <select name="categoria_id" class="form-control custom-input @error('categoria_id') is-invalid @enderror" required>
                                <option value="">-- Selecciona una categoría --</option>
                                @foreach ($categorias as $categoria)
                                    <option value="{{ $categoria->id }}" 
                                        {{ old('categoria_id', $producto->categoria_id) == $categoria->id ? 'selected' : '' }}>
                                        {{ $categoria->nombre }}
                                    </option>
                                @endforeach
                            </select>
                            @error('categoria_id')
                                <div class="invalid-feedback custom-invalid">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        {{-- Precio --}}
                        <div class="form-group mb-4">
                            <label for="precio" class="form-label custom-label">
                                <i class="fas fa-dollar-sign text-dorado mr-2"></i>Precio (Bs.) <span class="text-danger">*</span>
                            </label>
                            <input type="number" step="0.01" class="form-control custom-input @error('precio') is-invalid @enderror" 
                                   name="precio" value="{{ old('precio', $producto->precio) }}" required>
                            @error('precio')
                                <div class="invalid-feedback custom-invalid">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Stock --}}
                        <div class="form-group mb-4">
                            <label for="stock" class="form-label custom-label">
                                <i class="fas fa-boxes text-dorado mr-2"></i>Stock <span class="text-danger">*</span>
                            </label>
                            <input type="number" class="form-control custom-input @error('stock') is-invalid @enderror" 
                                   name="stock" value="{{ old('stock', $producto->stock) }}" required>
                            @error('stock')
                                <div class="invalid-feedback custom-invalid">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- Imagen --}}
                <div class="form-group mb-4">
                    <label for="imagen" class="form-label custom-label">
                        <i class="fas fa-camera text-dorado mr-2"></i>Imagen del Producto
                    </label>
                    
                    {{-- Imagen actual --}}
                    @if($producto->imagen)
                    <div class="current-image mb-3">
                        <label class="form-label custom-label text-success">
                            <i class="fas fa-image mr-2"></i>Imagen Actual:
                        </label>
                        <div class="current-image-wrapper">
                            <img src="{{ asset('storage/' . $producto->imagen) }}" 
                                 class="img-current-product" 
                                 alt="Imagen actual de {{ $producto->nombre }}">
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
                        <img id="image-preview" class="img-preview-product" src="#" alt="Vista previa de la nueva imagen">
                    </div>
                </div>

                <div class="text-center mt-4 pt-3 border-top">
                    <button type="submit" class="btn btn-custom btn-lg px-5">
                        <i class="fas fa-save mr-2"></i>Actualizar Producto
                    </button>
                    <a href="{{ route('admin.productos.index') }}" class="btn btn-outline-custom btn-lg px-5 ml-3">
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
/* Estilos específicos para edición de productos */
.img-current-product {
    width: 100px;
    height: 100px;
    border-radius: 8px;
    object-fit: cover;
    border: 3px solid var(--color-dorado);
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
}

.product-info {
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