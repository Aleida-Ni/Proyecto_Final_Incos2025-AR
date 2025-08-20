@extends('adminlte::page')

@section('title', 'Lista de Productos')

@section('content')
<h1 class="text-black text-center mb-4">Lista de Productos</h1>

<!-- Filtro por categoría -->
<form method="GET" action="{{ route('admin.productos.index') }}" class="mb-3">
    <div class="row">
        <div class="col-md-4">
            <select name="categoria_id" class="form-control" onchange="this.form.submit()">
                <option value="">-- Ver todas las categorías --</option>
                @foreach ($categorias as $categoria)
                    <option value="{{ $categoria->id }}" 
                        {{ request('categoria_id') == $categoria->id ? 'selected' : '' }}>
                        {{ $categoria->nombre }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <a href="{{ route('admin.productos.index') }}" class="btn btn-secondary">Reset</a>
        </div>
    </div>
</form>

<a href="{{ route('admin.productos.create') }}" class="btn btn-producto mb-3">Agregar Producto</a>

<!-- Mostrar productos -->
@if(request('categoria_id'))
    {{-- Vista filtrada --}}
    <table class="table custom-table">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Categoría</th>
                <th>Precio</th>
                <th>Stock</th>
                <th>Imagen</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($productos as $producto)
                <tr>
                    <td>{{ $producto->nombre }}</td>
                    <td>{{ $producto->categoria ? $producto->categoria->nombre : 'Sin categoría' }}</td>
                    <td>{{ $producto->precio }}</td>
                    <td>{{ $producto->stock }}</td>
                    <td>
                        @if($producto->imagen)
                            <img src="{{ asset('storage/' . $producto->imagen) }}" width="80">
                        @else
                            Sin imagen
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('admin.productos.edit', $producto->id) }}" class="btn btn-sm btn-editar">Editar</a>
                        <form action="{{ route('admin.productos.destroy', $producto->id) }}" method="POST" style="display:inline;">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-eliminar" onclick="return confirm('¿Seguro?')">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@else
    {{-- Vista agrupada por categoría --}}
    @foreach ($categorias as $categoria)
        <h3 class="mt-4">{{ $categoria->nombre }}</h3>
        <table class="table custom-table">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Precio</th>
                    <th>Stock</th>
                    <th>Imagen</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($productos->where('categoria_id', $categoria->id) as $producto)
                    <tr>
                        <td>{{ $producto->nombre }}</td>
                        <td>{{ $producto->precio }}</td>
                        <td>{{ $producto->stock }}</td>
                        <td>
                            @if($producto->imagen)
                                <img src="{{ asset('storage/' . $producto->imagen) }}" width="80">
                            @else
                                Sin imagen
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('admin.productos.edit', $producto->id) }}" class="btn btn-sm btn-editar">Editar</a>
                            <form action="{{ route('admin.productos.destroy', $producto->id) }}" method="POST" style="display:inline;">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-eliminar" onclick="return confirm('¿Seguro?')">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endforeach
@endif
@endsection
