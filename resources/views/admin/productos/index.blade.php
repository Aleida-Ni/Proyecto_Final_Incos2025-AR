@extends('adminlte::page')

@section('title', 'Lista de Productos')

@section('content')
<div class="container mt-4">

    <!-- Cabecera -->
    <h1 class="text-center text-dark py-3 mb-0">
        Lista de Productos
    </h1>

    <div class="report-container">

        <!-- Etiquetas de categorías -->
        <div class="text-center mb-3">
            @foreach ($categorias as $categoria)
                <span class="categoria-label">{{ strtoupper($categoria->nombre) }}</span>
            @endforeach
        </div>

        <!-- Filtro por categoría -->
        <form method="GET" action="{{ route('admin.productos.index') }}" class="mb-4">
            <div class="row justify-content-center">
                <div class="col-md-4">
                    <select name="categoria_id" class="form-control filter-input" onchange="this.form.submit()">
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
                    <a href="{{ route('admin.productos.index') }}" class="btn btn-reset w-100">Reset</a>
                </div>
            </div>
        </form>

        <!-- Botón Agregar -->
        <div class="text-right mb-3">
            <a href="{{ route('admin.productos.create') }}" class="btn btn-add">Agregar Producto</a>
        </div>

        <!-- Mostrar productos -->
        @if(request('categoria_id'))
            @php
                $categoria = $categorias->firstWhere('id', request('categoria_id'));
                $productosCat = $productos->where('categoria_id', $categoria->id);
            @endphp

            <h3 class="categoria-titulo">{{ strtoupper($categoria->nombre) }}</h3>
            @includeWhen($productosCat->isNotEmpty(), 'admin.productos.index', ['productosCat' => $productosCat])
            <div class="table-responsive">
                <table class="table report-table">
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
                        @forelse ($productosCat as $producto)
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
                        @empty
                            <tr><td colspan="5" class="text-center">Sin registro de productos</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        @else
            @foreach ($categorias as $categoria)
                <h3 class="categoria-titulo">{{ strtoupper($categoria->nombre) }}</h3>
                <div class="table-responsive">
                    <table class="table report-table">
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
                            @forelse ($productos->where('categoria_id', $categoria->id) as $producto)
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
                            @empty
                                <tr><td colspan="5" class="text-center">Sin registro de productos</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            @endforeach
        @endif

    </div>
</div>
@stop

@push('css')
<style>
/* ======== CONTENEDOR PRINCIPAL ======== */
body {
    background-color: #fff !important;
}

.report-container {
    padding: 25px;
    border: 2px solid #000;
    border-radius: 10px;
    background: #fff;
    color: #000;
    max-width: 1100px;
    margin: 0 auto;
}

/* ======== ETIQUETAS ======== */
.categoria-label {
    display: inline-block;
    background: #000;
    color: #fff;
    font-weight: bold;
    padding: 6px 14px;
    margin: 3px;
    border-radius: 20px;
    transition: background 0.3s;
}
.categoria-label:hover {
    background: #444;
}

/* ======== FILTROS ======== */
.filter-input {
    background: #fff;
    color: #000;
    border: 2px solid #000;
    border-radius: 8px;
}
.filter-input:focus {
    border-color: #007bff;
    box-shadow: 0 0 5px rgba(0,123,255,0.3);
}

/* ======== BOTONES ======== */
.btn-reset, .btn-add {
    border: 2px solid #000;
    border-radius: 8px;
    padding: 8px 15px;
    font-weight: 600;
    color: #000;
    transition: 0.3s;
}
.btn-reset {
    background: #e2e8f0;
}
.btn-reset:hover {
    background: #cbd5e0;
}
.btn-add {
    background: #007bff;
    color: #fff;
    border: none;
}
.btn-add:hover {
    background: #0056b3;
}

/* ======== TABLAS ======== */
.report-table {
    width: 100%;
    background: #fff;
    border: 2px solid #000;
    border-radius: 10px;
    color: #000;
    margin-bottom: 25px;
    overflow: hidden;
}
.report-table thead {
    background: #f5f5f5;
    font-weight: bold;
}
.report-table th, .report-table td {
    padding: 12px 15px;
    text-align: center;
    border: 1px solid #000;
}

/* ======== IMÁGENES ======== */
.product-img {
    width: 60px;
    height: 60px;
    object-fit: cover;
    border: 2px solid #000;
    border-radius: 50%;
    transition: all 0.3s ease;
}
.product-img:hover {
    transform: scale(1.2);
    border-radius: 0;
}

/* ======== BOTONES ACCIÓN ======== */
.btn-editar, .btn-eliminar {
    border: none;
    padding: 6px 15px;
    border-radius: 8px;
    font-weight: 600;
    color: #fff;
    cursor: pointer;
    transition: all 0.3s ease;
}
.btn-editar {
    background: #17a2b8;
}
.btn-editar:hover {
    background: #138496;
    transform: translateY(-2px);
}
.btn-eliminar {
    background: #e63946;
}
.btn-eliminar:hover {
    background: #c53030;
    transform: translateY(-2px);
}

/* ======== TITULOS ======== */
.categoria-titulo {
    border-bottom: 2px solid #000;
    padding-bottom: 5px;
    margin-top: 30px;
    margin-bottom: 10px;
    font-weight: bold;
}
</style>
@endpush
