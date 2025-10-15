@extends('cliente.layout')

@section('title', 'Productos')

@section('content')
<div class="container my-5">

    <h1 class="text-center mb-5 fw-bold text-dark">Nuestros Productos</h1>

    {{-- Botón de Categorías --}}
    <div class="text-center mb-4">
        <div class="dropdown-categorias d-inline-block position-relative">
            <button class="btn btn-outline-dark fw-semibold dropdown-toggle categorias-trigger" type="button">
                Categorías
            </button>
            <div class="categorias-menu shadow-sm">
                <a href="{{ route('cliente.productos.index') }}">Todas</a>
                <a href="{{ route('cliente.productos.index', ['categoria' => 'CERAS Y GELES']) }}">Ceras y Geles</a>
                <a href="{{ route('cliente.productos.index', ['categoria' => 'CUIDADOS DE BARBA']) }}">Cuidados de Barba</a>
                <a href="{{ route('cliente.productos.index', ['categoria' => 'CAPAS PERSONALIZADAS']) }}">Capas Personalizadas</a>
            </div>
        </div>
    </div>

    @php
    $productosPorCategoria = $productos->groupBy(function($p){
        return optional($p->categoria)->nombre ?? 'Sin categoría';
    });
    @endphp

    @foreach($productosPorCategoria as $categoriaNombre => $items)
        <h3 class="text-dark mt-5 mb-4 fw-bold border-start border-4 border-dark ps-3">
            {{ strtoupper($categoriaNombre) }}
        </h3>
        <div class="row">
            @foreach($items as $producto)
                <div class="col-md-4 col-lg-3 mb-4">
                    <div class="card producto-card border-0 shadow-sm h-100">
                        @if($producto->imagen)
                            <div class="producto-img-container">
                                <img src="{{ asset('storage/' . $producto->imagen) }}" 
                                     alt="Imagen de {{ $producto->nombre }}" 
                                     class="producto-img">
                                <div class="overlay">
                                    <span class="price-tag">Bs. {{ number_format($producto->precio, 2) }}</span>
                                </div>
                            </div>
                        @else
                            <div class="no-img">Sin Imagen</div>
                        @endif

                        <div class="card-body text-center">
                            <h5 class="fw-semibold text-dark mb-2">{{ $producto->nombre }}</h5>
                            <p class="text-muted small mb-0">Categoría: {{ $categoriaNombre }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endforeach

</div>

<style>
    body {
        background-color: #fff !important;
        font-family: 'Poppins', sans-serif;
    }

    /* Encabezado */
    h1 {
        text-shadow: 0 0 8px rgba(0,0,0,0.1);
        letter-spacing: 1px;
    }

    /* Dropdown de categorías */
    .categorias-trigger {
        border-radius: 25px;
        transition: 0.3s ease;
    }
    .categorias-trigger:hover {
        background-color: #000;
        color: #fff;
    }

    .categorias-menu {
        display: none;
        position: absolute;
        top: 105%;
        left: 50%;
        transform: translateX(-50%);
        background: #fff;
        border-radius: 12px;
        padding: 8px 0;
        min-width: 240px;
        z-index: 1000;
        border: 1px solid #e0e0e0;
    }
    .dropdown-categorias:hover .categorias-menu {
        display: block;
    }
    .categorias-menu a {
        display: block;
        padding: 10px 16px;
        color: #212529;
        font-weight: 500;
        text-align: left;
        text-decoration: none;
    }
    .categorias-menu a:hover {
        background-color: #f8f9fa;
        color: #0d6efd;
    }

    /* Tarjetas de producto */
    .producto-card {
        border-radius: 16px;
        transition: all 0.3s ease;
        overflow: hidden;
        position: relative;
    }
    .producto-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.1);
    }

    .producto-img-container {
        position: relative;
        overflow: hidden;
    }
    .producto-img {
        width: 100%;
        height: 230px;
        object-fit: cover;
        transition: transform 0.3s ease;
    }
    .producto-card:hover .producto-img {
        transform: scale(1.07);
    }

    /* Overlay con precio */
    .overlay {
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        height: 60px;
        background: linear-gradient(to top, rgba(0, 0, 0, 0.7), transparent);
        display: flex;
        align-items: flex-end;
        justify-content: center;
        opacity: 0;
        transition: opacity 0.3s ease;
        padding-bottom: 10px;
    }
    .producto-card:hover .overlay {
        opacity: 1;
    }
    .price-tag {
        background: #0d6efd;
        color: #fff;
        font-weight: 600;
        border-radius: 30px;
        padding: 6px 14px;
        font-size: 0.9rem;
        box-shadow: 0 3px 10px rgba(0,0,0,0.3);
    }

    .no-img {
        height: 230px;
        background-color: #ccc;
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        font-size: 1rem;
    }
</style>
@endsection
