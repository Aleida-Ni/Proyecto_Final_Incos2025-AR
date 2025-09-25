@extends('adminlte::page')

@section('title', 'Lista de Productos')

@section('css')
<link rel="stylesheet" href="{{ asset('css/custom.css') }}">
@endsection

@section('content')
<div class="content-wrapper"> {{-- AdminLTE wrapper correcto --}}
    <div class="container mt-4 table-container">
        <h1 class="text-center text-dark title-shadow mb-4">
            Lista de Productos
        </h1>

        <!-- Filtro por categoría -->
        <form method="GET" action="{{ route('admin.productos.index') }}" class="mb-4">
            <div class="row justify-content-center">
                <div class="col-md-4">
                    <select name="categoria_id" class="form-control border-black shadow-sm" onchange="this.form.submit()">
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
                    <a href="{{ route('admin.productos.index') }}" class="btn btn-custom w-100">🔄 Reset</a>
                </div>
            </div>
        </form>

        <!-- Botón agregar producto -->
        <div class="text-right mb-3">
            <a href="{{ route('admin.productos.create') }}" class="btn btn-custom">Agregar Producto</a>
        </div>

        <!-- Tabla de productos -->
        @if(request('categoria_id'))
            <table class="table custom-table shadow-lg">
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
                            <td>{{ $producto->precio }} Bs</td>
                            <td>{{ $producto->stock }}</td>
                            <td>
                                @if($producto->imagen)
                                    <img src="{{ asset('storage/' . $producto->imagen) }}" class="product-img">
                                @else
                                    <span class="text-muted">Sin imagen</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.productos.edit', $producto->id) }}" class="btn-editar">✏ Editar</a>
                                <form action="{{ route('admin.productos.destroy', $producto->id) }}" method="POST" class="d-inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn-eliminar" 
                                            onclick="return confirm('¿Seguro que deseas eliminar este producto?')">🗑 Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            @foreach ($categorias as $categoria)
                <h3 class="mt-5 text-dark border-bottom pb-2">{{ $categoria->nombre }}</h3>
                <table class="table custom-table shadow-sm">
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
                                <td>{{ $producto->precio }} Bs</td>
                                <td>{{ $producto->stock }}</td>
                                <td>
                                    @if($producto->imagen)
                                        <img src="{{ asset('storage/' . $producto->imagen) }}" class="product-img">
                                    @else
                                        <span class="text-muted">Sin imagen</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('admin.productos.edit', $producto->id) }}" class="btn-editar">Editar</a>
                                    <form action="{{ route('admin.productos.destroy', $producto->id) }}" method="POST" class="d-inline">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn-eliminar"
                                                onclick="return confirm('¿Seguro que deseas eliminar este producto?')">Eliminar</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endforeach
        @endif
    </div>
</div>
@stop
@push('css')
<style>
/* ==================== CONTENEDOR ==================== */
.table-container {
    background-color: #e5e5e5; /* plomo claro */
    padding: 20px;
    border-radius: 12px;
    box-shadow: 0 8px 20px rgba(0,0,0,0.05);
    position: relative; /* importante */
}

/* ==================== TABLAS ==================== */
.custom-table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
    border-radius: 12px;
    overflow: hidden;
    background-color: #f0f0f0; /* plomo */
    box-shadow: 0 4px 12px rgba(0,0,0,0.05);
}

.custom-table thead {
    background-color: #c0c0c0; /* encabezado más oscuro */
    color: #111;
    font-weight: bold;
}

.custom-table th, .custom-table td {
    padding: 12px 15px;
    text-align: center;
    vertical-align: middle;
    color: #222;
}

/* Hover fila */
.custom-table tbody tr:hover {
    background-color: #d0d0d0; /* plomo medio */
    transform: scale(1.02);
    transition: all 0.3s ease;
}

/* ==================== IMAGEN ==================== */
.product-img {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    object-fit: cover;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.product-img:hover {
    transform: scale(1.2);
    box-shadow: 0 8px 20px rgba(0,0,0,0.2);
}

/* ==================== BOTONES ==================== */
.btn-editar {
    background: none;
    border: none;
    color: #111; /* negro */
    text-shadow: 1px 1px 2px #aaa; /* destello plomo */
    font-weight: bold;
    cursor: pointer;
    transition: 0.3s;
}

.btn-editar:hover {
    color: #000;
    text-shadow: 2px 2px 6px #999;
    transform: scale(1.1);
}

.btn-eliminar {
    background: none;
    border: none;
    color: #e53e3e; /* rojo */
    text-shadow: 1px 1px 2px #c53030; /* destello rojo */
    font-weight: bold;
    cursor: pointer;
    transition: 0.3s;
}

.btn-eliminar:hover {
    color: #c53030;
    text-shadow: 2px 2px 6px #a80000;
    transform: scale(1.1);
}

/* ==================== RESPONSIVE ==================== */
@media (max-width: 768px) {
    .custom-table th, .custom-table td {
        padding: 8px 10px;
        font-size: 0.9rem;
    }
    
    .btn-editar, .btn-eliminar {
        font-size: 0.85rem;
    }

    .product-img {
        width: 50px;
        height: 50px;
    }
}

/* ==================== EVITAR SUPERPOSICIÓN ==================== */
.content-wrapper {
    position: relative;
    z-index: 0; /* debajo de sidebar y navbar */
}

</style>
@endpush
