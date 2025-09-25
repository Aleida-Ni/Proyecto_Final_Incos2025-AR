@extends('adminlte::page')
@section('css')
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
@endsection
@section('content')
<h1>Editar Producto</h1>
<form action="{{ route('admin.productos.update', $producto->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label for="nombre" class="form-label">Nombre</label>
        <input type="text" class="form-control" name="nombre" value="{{ $producto->nombre }}" required>
    </div>

    {{-- Categoría --}}
    <div class="mb-3">
        <label for="categoria_id" class="form-label">Categoría</label>
        <select name="categoria_id" class="form-control" required>
            <option value="">-- Selecciona una categoría --</option>
            @foreach ($categorias as $categoria)
                <option value="{{ $categoria->id }}" 
                    {{ $producto->categoria_id == $categoria->id ? 'selected' : '' }}>
                    {{ $categoria->nombre }}
                </option>
            @endforeach
        </select>
    </div>



    <div class="mb-3">
        <label for="precio" class="form-label">Precio</label>
        <input type="number" step="0.01" class="form-control" name="precio" value="{{ $producto->precio }}" required>
    </div>

    <div class="mb-3">
        <label for="stock" class="form-label">Stock</label>
        <input type="number" class="form-control" name="stock" value="{{ $producto->stock }}" required>
    </div>

    <div class="mb-3">
        <label for="imagen" class="form-label">Imagen</label>
        <input type="file" class="form-control" name="imagen">
        @if($producto->imagen)
        <img src="{{ asset('storage/' . $producto->imagen) }}" width="80" class="mt-2">
        @endif
    </div>

    <button type="submit" class="btn btn-primary">Actualizar</button>
</form>
@endsection