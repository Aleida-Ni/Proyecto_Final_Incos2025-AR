@extends('adminlte::page')

@section('title', 'Lista de Productos')

@section('content')

<div class="container mt-4">
    <!-- Cabecera -->
    <h1 class="text-center bg-white text-dark py-3 mb-0">
        Lista de Productos
    </h1>

    <div class="report-container">

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

        <div class="text-right mb-3">
            <a href="{{ route('admin.productos.create') }}" class="btn btn-add">Agregar Producto</a>
        </div>

        @if(request('categoria_id'))
            @php
                $categoria = $categorias->firstWhere('id', request('categoria_id'));
                $productosCat = $productos->where('categoria_id', $categoria->id);
            @endphp

            <h3 class="text-light border-bottom pb-2">{{ strtoupper($categoria->nombre) }}</h3>
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
            <!-- Todas las categorías -->
            @foreach ($categorias as $categoria)
                <h3 class="text-light border-bottom pb-2">{{ strtoupper($categoria->nombre) }}</h3>
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
.report-container {
    background: #6e6b6bff;
    padding: 25px;
    border: 1px solid #fff;
    border-top: none;
    max-width: 1100px;
    margin: 0 auto;
    color: #fff;
}

.categoria-label {
    display: inline-block;
    background: #fff;
    color: #000;
    font-weight: bold;
    padding: 5px 12px;
    margin: 3px;
    border: 1px solid #000;
}

.filter-input {
    background: #6e6b6bff;
    color: #fff;
    border: 1px solid #fff;
}

.filter-input option {
    background: #6e6b6bff;
    color: #fff;
}

.btn-reset, .btn-add {
    border: 1px solid #fff;
    border-radius: 0;
    padding: 8px 15px;
    font-weight: bold;
    color: #fff;
    transition: 0.3s;
}

.btn-reset {
    background: #4a5568;
}
.btn-reset:hover { background: #2d3748; }

.btn-add {
    background: #3b3c3dff;
}
.btn-add:hover { background: #2b6cb0; }

.report-table {
    width: 100%;
    background: #6e6b6bff;
    border: 1px solid #fff;
    color: #fff;
    margin-bottom: 20px;
}

.report-table thead {
    background: #6e6b6bff;
}

.report-table th, .report-table td {
    padding: 12px 15px;
    text-align: center;
    vertical-align: middle;
    border: 1px solid #fff;
}

.product-img {
    width: 60px;
    height: 60px;
    object-fit: cover;
    border: 1px solid #fff;
    border-radius: 50%; /* circulares */
    transition: all 0.3s ease;
}
.product-img:hover {
    transform: scale(1.2);
    border-radius: 0; /* cuadradas al pasar mouse */
}

/* ======== BOTONES ACCIONES ======== */
.btn-editar, .btn-eliminar {
    background: none;
    border: none;
    font-weight: bold;
    cursor: pointer;
    transition: 0.3s;
}
.btn-editar { color: #63b3ed; }
.btn-editar:hover { color: #4299e1; }
.btn-eliminar { color: #f56565; }
.btn-eliminar:hover { color: #c53030; }
</style>
@endpush
