@extends('adminlte::page')

@section('title', 'Lista de Productos')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="mb-0"><i class="fas fa-boxes text-gold"></i> Lista de Productos</h1>
        <a href="{{ route('admin.productos.create') }}" class="btn btn-custom">
            <i class="fas fa-plus mr-2"></i>Agregar Producto
        </a>
    </div>
@stop

@section('content')
<div class="container-fluid">
    <div class="card shadow-lg custom-card">
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success alert-custom text-center">
                    <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-custom text-center">
                    <i class="fas fa-exclamation-circle mr-2"></i>{{ session('error') }}
                </div>
            @endif

            <!-- Filtro por categoría -->
            <div class="row mb-4">
                <div class="col-md-8 mx-auto">
                    <form method="GET" action="{{ route('admin.productos.index') }}" class="filter-form">
                        <div class="input-group">
                            <select name="categoria_id" class="form-control custom-input" onchange="this.form.submit()">
                                <option value="">-- Ver todas las categorías --</option>
                                @foreach ($categorias as $categoria)
                                    <option value="{{ $categoria->id }}" 
                                        {{ request('categoria_id') == $categoria->id ? 'selected' : '' }}>
                                        {{ $categoria->nombre }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="input-group-append">
                                <a href="{{ route('admin.productos.index') }}" class="btn btn-outline-custom">
                                    <i class="fas fa-sync-alt mr-2"></i>Reset
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Etiquetas de categorías -->
            <div class="text-center mb-4">
                @foreach ($categorias as $categoria)
                    <span class="categoria-badge" 
                          onclick="filterByCategory({{ $categoria->id }})"
                          style="cursor: pointer;">
                        {{ strtoupper($categoria->nombre) }}
                    </span>
                @endforeach
            </div>

            <!-- Mostrar productos -->
            @if(request('categoria_id'))
                @php
                    $categoria = $categorias->firstWhere('id', request('categoria_id'));
                    $productosCat = $productos->where('categoria_id', $categoria->id);
                @endphp

                <div class="categoria-section">
                    <h3 class="categoria-titulo">
                        <i class="fas fa-tag mr-2"></i>{{ strtoupper($categoria->nombre) }}
                    </h3>
                    <div class="table-responsive">
                        <table class="table custom-table table-hover">
                            <thead>
                                <tr>
                                    <th width="60px">Imagen</th>
                                    <th>Nombre</th>
                                    <th>Precio</th>
                                    <th>Stock</th>
                                    <th width="120px">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($productosCat as $producto)
                                    <tr>
                                        <td>
                                            @if($producto->imagen)
                                                <img src="{{ asset('storage/' . $producto->imagen) }}" 
                                                     class="product-img-square"
                                                     alt="{{ $producto->nombre }}"
                                                     title="{{ $producto->nombre }}">
                                            @else
                                                <div class="img-placeholder-product">
                                                    <i class="fas fa-box"></i>
                                                </div>
                                            @endif
                                        </td>
                                        <td class="font-weight-bold text-gris-oscuro">{{ $producto->nombre }}</td>
                                        <td class="text-success font-weight-bold">{{ number_format($producto->precio, 2) }} Bs</td>
                                        <td>
                                            <span class="stock-badge {{ $producto->stock > 10 ? 'stock-high' : ($producto->stock > 0 ? 'stock-medium' : 'stock-low') }}">
                                                {{ $producto->stock }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('admin.productos.edit', $producto->id) }}" 
                                                   class="btn btn-sm btn-editar"
                                                   title="Editar producto">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('admin.productos.destroy', $producto->id) }}" method="POST">
                                                    @csrf 
                                                    @method('DELETE')
                                                    <button type="submit" 
                                                            class="btn btn-sm btn-eliminar"
                                                            onclick="return confirm('¿Estás seguro de eliminar este producto?')"
                                                            title="Eliminar producto">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-4">
                                            <div class="empty-state">
                                                <i class="fas fa-box-open fa-3x text-beige-oscuro mb-3"></i>
                                                <h4 class="text-gris-medio">No hay productos en esta categoría</h4>
                                                <p class="text-muted">Agrega el primer producto en {{ $categoria->nombre }}.</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            @else
                @foreach ($categorias as $categoria)
                    @php
                        $productosCategoria = $productos->where('categoria_id', $categoria->id);
                    @endphp
                    
                    @if($productosCategoria->isNotEmpty())
                    <div class="categoria-section">
                        <h3 class="categoria-titulo">
                            <i class="fas fa-tag mr-2"></i>{{ strtoupper($categoria->nombre) }}
                        </h3>
                        <div class="table-responsive">
                            <table class="table custom-table table-hover">
                                <thead>
                                    <tr>
                                        <th width="60px">Imagen</th>
                                        <th>Nombre</th>
                                        <th>Precio</th>
                                        <th>Stock</th>
                                        <th width="120px">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($productosCategoria as $producto)
                                        <tr>
                                            <td>
                                                @if($producto->imagen)
                                                    <img src="{{ asset('storage/' . $producto->imagen) }}" 
                                                         class="product-img-square"
                                                         alt="{{ $producto->nombre }}"
                                                         title="{{ $producto->nombre }}">
                                                @else
                                                    <div class="img-placeholder-product">
                                                        <i class="fas fa-box"></i>
                                                    </div>
                                                @endif
                                            </td>
                                            <td class="font-weight-bold text-gris-oscuro">{{ $producto->nombre }}</td>
                                            <td class="text-success font-weight-bold">{{ number_format($producto->precio, 2) }} Bs</td>
                                            <td>
                                                <span class="stock-badge {{ $producto->stock > 10 ? 'stock-high' : ($producto->stock > 0 ? 'stock-medium' : 'stock-low') }}">
                                                    {{ $producto->stock }}
                                                </span>
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="{{ route('admin.productos.edit', $producto->id) }}" 
                                                       class="btn btn-sm btn-editar"
                                                       title="Editar producto">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <form action="{{ route('admin.productos.destroy', $producto->id) }}" method="POST">
                                                        @csrf 
                                                        @method('DELETE')
                                                        <button type="submit" 
                                                                class="btn btn-sm btn-eliminar"
                                                                onclick="return confirm('¿Estás seguro de eliminar este producto?')"
                                                                title="Eliminar producto">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @endif
                @endforeach
            @endif

            @if($productos->isEmpty())
                <div class="text-center py-5">
                    <i class="fas fa-boxes fa-3x text-beige-oscuro mb-3"></i>
                    <h4 class="text-gris-medio">No hay productos registrados</h4>
                    <p class="text-muted">Comienza agregando tu primer producto al inventario.</p>
                    <a href="{{ route('admin.productos.create') }}" class="btn btn-custom mt-2">
                        <i class="fas fa-plus mr-2"></i>Agregar Primer Producto
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@section('css')
<style>
/* Estilos específicos para productos */
.categoria-badge {
    display: inline-block;
    background: linear-gradient(135deg, var(--color-gris-oscuro) 0%, var(--color-negro) 100%);
    color: var(--color-blanco);
    font-weight: 600;
    padding: 8px 16px;
    margin: 5px;
    border-radius: 20px;
    border: 2px solid var(--color-dorado);
    transition: all 0.3s ease;
    font-size: 0.85rem;
}

.categoria-badge:hover {
    background: linear-gradient(135deg, var(--color-dorado) 0%, var(--color-dorado-claro) 100%);
    color: var(--color-negro);
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(212, 175, 55, 0.3);
}

.categoria-section {
    margin-bottom: 30px;
    border: 1px solid var(--color-beige-oscuro);
    border-radius: 10px;
    padding: 20px;
    background: var(--color-blanco);
}

.categoria-titulo {
    border-bottom: 3px solid var(--color-dorado);
    padding-bottom: 10px;
    margin-bottom: 20px;
    color: var(--color-gris-oscuro);
    font-weight: 600;
    font-size: 1.3rem;
}

/* Imágenes de productos */
.product-img-square {
    width: 50px;
    height: 50px;
    border-radius: 8px;
    object-fit: cover;
    border: 2px solid var(--color-beige-oscuro);
    box-shadow: 0 2px 6px rgba(0,0,0,0.1);
    transition: all 0.3s ease;
}

.product-img-square:hover {
    transform: scale(1.2);
    border-color: var(--color-dorado);
    box-shadow: 0 4px 12px rgba(212, 175, 55, 0.3);
}

.img-placeholder-product {
    width: 50px;
    height: 50px;
    background: linear-gradient(135deg, var(--color-beige) 0%, var(--color-beige-oscuro) 100%);
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    border: 2px dashed var(--color-dorado-claro);
    color: var(--color-gris-medio);
    font-size: 1rem;
}

/* Indicadores de stock */
.stock-badge {
    padding: 4px 10px;
    border-radius: 12px;
    font-weight: 600;
    font-size: 0.8rem;
}

.stock-high {
    background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
    color: #155724;
    border: 1px solid #c3e6cb;
}

.stock-medium {
    background: linear-gradient(135deg, #fff3cd 0%, #ffeaa7 100%);
    color: #856404;
    border: 1px solid #ffeaa7;
}

.stock-low {
    background: linear-gradient(135deg, #f8d7da 0%, #f5c6cb 100%);
    color: #721c24;
    border: 1px solid #f5c6cb;
}

/* Filtros */
.filter-form {
    margin-bottom: 20px;
}

/* Responsive */
@media (max-width: 768px) {
    .categoria-badge {
        padding: 6px 12px;
        font-size: 0.8rem;
        margin: 3px;
    }
    
    .categoria-section {
        padding: 15px;
    }
    
    .product-img-square, .img-placeholder-product {
        width: 40px;
        height: 40px;
    }
    
    .stock-badge {
        font-size: 0.75rem;
        padding: 3px 8px;
    }
}
</style>
@endsection

@section('js')
<script>
function filterByCategory(categoriaId) {
    window.location.href = '{{ route("admin.productos.index") }}?categoria_id=' + categoriaId;
}
</script>
@endsection