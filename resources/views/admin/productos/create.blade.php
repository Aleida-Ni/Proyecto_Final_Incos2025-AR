@extends('adminlte::page')

@section('content')
    <h1>Agregar Producto</h1>
    <form action="{{ route('admin.productos.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre</label>
            <input type="text" class="form-control" name="nombre" required>
        </div>

<div class="mb-3">
    <label for="categoria_id" class="form-label">Categoría</label>
    <select name="categoria_id" class="form-control" required>
        <option value="">-- Selecciona una categoría --</option>
        <option value="1">CERAS Y GELES</option>
        <option value="2">CUIDADOS DE BARBA</option>
        <option value="3">CAPAS PERSONALIZADAS</option>
    </select>
</div>


        <div class="mb-3">
            <label for="precio" class="form-label">Precio</label>
            <input type="number" step="0.01" class="form-control" name="precio" required>
        </div>

        <div class="mb-3">
            <label for="stock" class="form-label">Stock</label>
            <input type="number" class="form-control" name="stock" required>
        </div>

        <div class="mb-3">
            <label for="imagen" class="form-label">Imagen</label>
            <input type="file" class="form-control" name="imagen">
        </div>

        <button type="submit" class="btn btn-success">Guardar</button>
    </form>
@endsection