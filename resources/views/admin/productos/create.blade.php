@extends('adminlte::page')

@section('title', 'Agregar Producto')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="mb-0"><i class="fas fa-plus-circle text-gold"></i> Agregar Nuevo Producto</h1>
        <a href="{{ route('admin.productos.index') }}" class="btn btn-outline-custom">
            <i class="fas fa-arrow-left mr-2"></i>Volver
        </a>
    </div>
@stop

@section('content')
<div class="container-fluid">
    <div class="card shadow-lg custom-card">
        <div class="card-header custom-card-header">
            <h3 class="card-title mb-0"><i class="fas fa-box mr-2"></i>Información del Producto</h3>
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

            <form action="{{ route('admin.productos.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="row">
                    <div class="col-md-6">
                        {{-- Nombre --}}
                        <div class="form-group mb-4">
                            <label for="nombre" class="form-label custom-label">
                                <i class="fas fa-tag text-dorado mr-2"></i>Nombre del Producto <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control custom-input @error('nombre') is-invalid @enderror" 
                                   id="nombre" name="nombre" value="{{ old('nombre') }}" 
                                   placeholder="Ingresa el nombre del producto" required>
                            @error('nombre')
                                <div class="invalid-feedback custom-invalid">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Categoría --}}
                        <div class="form-group mb-4">
                            <label for="categoria_id" class="form-label custom-label">
                                <i class="fas fa-list-alt text-dorado mr-2"></i>Categoría <span class="text-danger">*</span>
                            </label>
                            <select name="categoria_id" id="categoria_id" 
                                    class="form-control custom-input @error('categoria_id') is-invalid @enderror" required>
                                <option value="">-- Selecciona una categoría --</option>
                                @foreach($categorias as $categoria)
                                    <option value="{{ $categoria->id }}" 
                                        {{ old('categoria_id') == $categoria->id ? 'selected' : '' }}>
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
                                   id="precio" name="precio" value="{{ old('precio') }}" 
                                   placeholder="0.00" min="0" required>
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
                                   id="stock" name="stock" value="{{ old('stock') }}" 
                                   placeholder="0" min="0" required>
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
                    <div class="custom-file-input-wrapper">
                        <input type="file" class="custom-file-input @error('imagen') is-invalid @enderror" 
                               id="imagen" name="imagen" accept="image/*">
                        <label for="imagen" class="custom-file-label">
                            <i class="fas fa-upload mr-2"></i>Seleccionar archivo
                        </label>
                        @error('imagen')
                            <div class="invalid-feedback custom-invalid d-block">{{ $message }}</div>
                        @enderror
                    </div>
                    <small class="form-text text-muted mt-2">
                        Formatos permitidos: JPG, PNG, GIF. Tamaño máximo: 2MB
                    </small>
                </div>

                {{-- Previsualización de imagen --}}
                <div class="form-group mb-4 d-none" id="image-preview-container">
                    <label class="form-label custom-label">Vista previa:</label>
                    <div class="image-preview-wrapper">
                        <img id="image-preview" class="img-preview-product" src="#" alt="Vista previa de la imagen">
                    </div>
                </div>

                <div class="text-center mt-4 pt-3 border-top">
                    <button type="submit" class="btn btn-custom btn-lg px-5">
                        <i class="fas fa-save mr-2"></i>Guardar Producto
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
/* Estilos específicos para productos */
.img-preview-product {
    width: 150px;
    height: 150px;
    border-radius: 10px;
    object-fit: cover;
    border: 3px solid var(--color-dorado);
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
}

.image-preview-wrapper {
    display: inline-block;
    padding: 10px;
    background: var(--color-beige);
    border-radius: 12px;
    border: 2px solid var(--color-beige-oscuro);
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