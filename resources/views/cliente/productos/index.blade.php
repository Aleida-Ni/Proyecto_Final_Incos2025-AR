@extends('cliente.layout')

@section('title', 'Productos')

@section('content')
    <h1 class="text-center mb-3">Nuestros Productos</h1>

    {{-- Botón de Categorías (sin fondo) con despliegue al hover / click --}}
    <div class="categorias-wrapper text-center mb-4">
        <div class="dropdown-categorias d-inline-block">
            <a href="#" class="btn btn-link categorias-trigger">Categorías ▾</a>
            <div class="categorias-menu">
                <a href="{{ route('productos.index') }}">Todas</a>
                <a href="{{ route('productos.index', ['categoria' => 'CERAS Y GELES']) }}">Ceras y Geles</a>
                <a href="{{ route('productos.index', ['categoria' => 'CUIDADOS DE BARBA']) }}">Cuidados de Barba</a>
                <a href="{{ route('productos.index', ['categoria' => 'CAPAS PERSONALIZADAS']) }}">Capas Personalizadas</a>
            </div>
        </div>
    </div>

    @if(request('categoria') && request('categoria') !== 'todas')
        {{-- Vista normal: productos filtrados --}}
        <div class="row">
            @foreach($productos as $producto)
                <div class="col-md-3 mb-4">
                    <div class="producto-card">
                        @if($producto->imagen)
                            <img src="{{ asset('storage/' . $producto->imagen) }}"
                                 alt="Imagen de {{ $producto->nombre }}" class="producto-img">
                        @else
                            <div class="no-img">Sin Imagen</div>
                        @endif
                        <div class="info p-3 text-center">
                            <h5>{{ $producto->nombre }}</h5>
                            <p>Precio: Bs. {{ number_format($producto->precio, 2) }}</p>

                            <form action="{{ route('cliente.ventas.agregar', $producto->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-primary btn-agregar">
                                    <i class="fas fa-shopping-cart"></i> Agregar
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        {{-- Vista agrupada por categoría --}}
        @php
            // Agrupar de forma segura, incluso si algún producto no tiene categoría
            $productosPorCategoria = $productos->groupBy(function($p){
                return optional($p->categoria)->nombre ?? 'Sin categoría';
            });
        @endphp

        @foreach($productosPorCategoria as $categoriaNombre => $items)
            <h3 class="text-white mt-4 mb-3" style="text-shadow: 0 0 8px #00cfff;">
                {{ $categoriaNombre }}
            </h3>
            <div class="row">
                @foreach($items as $producto)
                    <div class="col-md-3 mb-4">
                        <div class="producto-card">
                            @if($producto->imagen)
                                <img src="{{ asset('storage/' . $producto->imagen) }}"
                                     alt="Imagen de {{ $producto->nombre }}" class="producto-img">
                            @else
                                <div class="no-img">Sin Imagen</div>
                            @endif
                            <div class="info p-3 text-center">
                                <h5>{{ $producto->nombre }}</h5>
                                <p>Precio: Bs. {{ number_format($producto->precio, 2) }}</p>

                                <form action="{{ route('cliente.ventas.agregar', $producto->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-primary btn-agregar">
                                        <i class="fas fa-shopping-cart"></i> Agregar
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endforeach
    @endif

    <style>
        body { background-color: #000000 !important; }
        h1 { color: white; text-shadow: 0 0 10px #00cfff, 0 0 20px #0077cc; }

        /* Botón categorías sin fondo */
        .categorias-trigger {
            background: transparent !important;
            border: none !important;
            color: #ffffff !important;
            font-weight: 600;
            text-decoration: none;
            padding: .25rem .5rem;
        }
        .categorias-trigger:hover { color: #00cfff !important; text-decoration: none; }

        /* Dropdown de categorías */
        .dropdown-categorias { position: relative; }
        .categorias-menu {
            display: none;
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
            background: #0b0b0b;
            border: 1px solid #222;
            border-radius: 12px;
            padding: 8px 0;
            min-width: 260px;
            z-index: 1000;
            box-shadow: 0 12px 30px rgba(0,0,0,.45);
        }
        .dropdown-categorias:hover .categorias-menu { display: block; } /* hover desktop */
        .categorias-menu.show { display: block; } /* toggle mobile */

        .categorias-menu a {
            display: block;
            padding: 10px 16px;
            color: #e5e5e5;
            font-weight: 500;
            white-space: nowrap;
        }
        .categorias-menu a:hover {
            background: #111827;
            color: #00cfff;
            text-decoration: none;
        }

        .producto-card {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 2px 15px rgba(0,0,0,0.1);
            overflow: hidden;
            transition: 0.3s ease-in-out;
        }
        .producto-img { width: 100%; height: 200px; object-fit: cover; transition: transform 0.3s ease; }
        .producto-card:hover .producto-img { transform: scale(1.05); }
        .no-img {
            height: 200px; background-color: #6c757d; color: white;
            display: flex; align-items: center; justify-content: center;
            font-weight: bold; border-radius: 0.375rem 0.375rem 0 0;
        }
        .btn-agregar { background-color: #0077cc; border: none; transition: background-color 0.3s; }
        .btn-agregar:hover { background-color: #00cfff; color: black; }
    </style>

    {{-- Soporte móvil: abrir/cerrar menú de categorías al click --}}
    <script>
        document.addEventListener('DOMContentLoaded', function(){
            const trigger = document.querySelector('.categorias-trigger');
            const menu = document.querySelector('.categorias-menu');
            if (trigger && menu) {
                trigger.addEventListener('click', function(e){
                    e.preventDefault();
                    menu.classList.toggle('show');
                });
                document.addEventListener('click', function(e){
                    if (!e.target.closest('.dropdown-categorias')) {
                        menu.classList.remove('show');
                    }
                });
            }
        });
    </script>
@endsection
