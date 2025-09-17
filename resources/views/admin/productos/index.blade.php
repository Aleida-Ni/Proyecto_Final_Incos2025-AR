@extends('adminlte::page')

@section('title', 'Lista de Productos')

@section('content')
<div class="container mt-4">
    <h1 class="text-center mb-4 text-primary" style="text-shadow: 0 0 5px #00aaff, 0 0 10px #00ccff;">
        📦 Lista de Productos
    </h1>

    <!-- Filtro por categoría -->
    <form method="GET" action="{{ route('admin.productos.index') }}" class="mb-4">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <select name="categoria_id" class="form-control border-info shadow-sm" onchange="this.form.submit()">
                    <option value="">-- Ver todas las categorías --</option>
                    @foreach ($categorias as $categoria)
                        <option value="{{ $categoria->id }}" 
                            {{ request('categoria_id') == $categoria->id ? 'selected' : '' }}>
                            {{ $categoria->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2 text-center">
                <a href="{{ route('admin.productos.index') }}" class="btn btn-secondary w-100">🔄 Reset</a>
            </div>
        </div>
    </form>

    <!-- Botón agregar producto -->
    <div class="text-right mb-3">
        <a href="{{ route('admin.productos.create') }}" class="btn btn-success px-4" 
           style="border-radius: 25px; font-weight: 600; box-shadow: 0 4px 12px rgba(0,255,170,0.4);">
            ➕ Agregar Producto
        </a>
    </div>

    <!-- Mostrar productos -->
    @if(request('categoria_id'))
        {{-- Vista filtrada --}}
        <table class="table custom-table shadow-lg">
            <thead class="bg-dark text-white text-center">
                <tr>
                    <th>Nombre</th>
                    <th>Categoría</th>
                    <th>Precio</th>
                    <th>Stock</th>
                    <th>Imagen</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody class="text-center align-middle">
                @foreach ($productos as $producto)
                    <tr>
                        <td>{{ $producto->nombre }}</td>
                        <td>{{ $producto->categoria ? $producto->categoria->nombre : 'Sin categoría' }}</td>
                        <td><span class="badge bg-success">{{ $producto->precio }} Bs</span></td>
                        <td><span class="badge bg-info">{{ $producto->stock }}</span></td>
                        <td>
                            @if($producto->imagen)
                                <img src="{{ asset('storage/' . $producto->imagen) }}" width="80" class="rounded shadow">
                            @else
                                <span class="text-muted">Sin imagen</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('admin.productos.edit', $producto->id) }}" 
                               class="btn btn-warning btn-sm">✏ Editar</a>
                            <form action="{{ route('admin.productos.destroy', $producto->id) }}" 
                                  method="POST" class="d-inline">
                                @csrf @method('DELETE')
                                <button class="btn btn-danger btn-sm" 
                                        onclick="return confirm('¿Seguro que deseas eliminar este producto?')">🗑 Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        {{-- Vista agrupada por categoría --}}
        @foreach ($categorias as $categoria)
            <h3 class="mt-5 text-dark border-bottom pb-2">
                📂 {{ $categoria->nombre }}
            </h3>
            <table class="table custom-table shadow-sm">
                <thead class="bg-primary text-white text-center">
                    <tr>
                        <th>Nombre</th>
                        <th>Precio</th>
                        <th>Stock</th>
                        <th>Imagen</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody class="text-center align-middle">
                    @foreach ($productos->where('categoria_id', $categoria->id) as $producto)
                        <tr>
                            <td>{{ $producto->nombre }}</td>
                            <td><span class="badge bg-success">{{ $producto->precio }} Bs</span></td>
                            <td><span class="badge bg-info">{{ $producto->stock }}</span></td>
                            <td>
                                @if($producto->imagen)
                                    <img src="{{ asset('storage/' . $producto->imagen) }}" width="80" class="rounded shadow">
                                @else
                                    <span class="text-muted">Sin imagen</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.productos.edit', $producto->id) }}" 
                                   class="btn btn-warning btn-sm">✏ Editar</a>
                                <form action="{{ route('admin.productos.destroy', $producto->id) }}" 
                                      method="POST" class="d-inline">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-danger btn-sm" 
                                            onclick="return confirm('¿Seguro que deseas eliminar este producto?')">🗑 Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endforeach
    @endif
</div>

{{-- Estilos personalizados --}}
<style>
    .custom-table {
        border-radius: 12px;
        overflow: hidden;
    }

    .custom-table thead {
        font-size: 1rem;
        letter-spacing: 1px;
    }

    .custom-table tbody tr:hover {
        background: rgba(0, 170, 255, 0.1);
        transition: 0.3s;
    }

    .btn-editar {
        background: #ffc107;
        color: #111;
        font-weight: bold;
        border-radius: 20px;
    }

    .btn-eliminar {
        background: #dc3545;
        color: #fff;
        font-weight: bold;
        border-radius: 20px;
    }

    .btn-editar:hover {
        background: #e0a800;
        transform: scale(1.05);
    }

    .btn-eliminar:hover {
        background: #c82333;
        transform: scale(1.05);
    }
</style>
@endsection