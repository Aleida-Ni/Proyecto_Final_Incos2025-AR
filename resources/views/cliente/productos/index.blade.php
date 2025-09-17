@extends('cliente.layout')

@section('title', 'Productos')

@section('content')
<h1 class="text-center mb-3 d-flex justify-content-center align-items-center">
    Nuestros Productos
    <button type="button" class="btn btn-outline-light ms-3" data-bs-toggle="modal" data-bs-target="#carritoModal">
        <i class="fas fa-shopping-cart"></i>
        <span class="badge bg-danger" id="carrito-count">{{ session('carrito') ? array_sum(array_column(session('carrito'), 'cantidad')) : 0 }}</span>
    </button>
</h1>

{{-- Botón de Categorías --}}
<div class="categorias-wrapper text-center mb-4">
    <div class="dropdown-categorias d-inline-block">
        <a href="#" class="btn btn-link categorias-trigger">Categorías ▾</a>
        <div class="categorias-menu">
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
<h3 class="text-white mt-4 mb-3" style="text-shadow: 0 0 8px #00cfff;">
    {{ $categoriaNombre }}
</h3>
<div class="row">
    @foreach($items as $producto)
    <div class="col-md-3 mb-4">
        <div class="producto-card">
            @if($producto->imagen)
            <img src="{{ asset('storage/' . $producto->imagen) }}" alt="Imagen de {{ $producto->nombre }}" class="producto-img">
            @else
            <div class="no-img">Sin Imagen</div>
            @endif
            <div class="info p-3 text-center">
                <h5>{{ $producto->nombre }}</h5>
                <p>Precio: Bs. {{ number_format($producto->precio, 2) }}</p>

                <form action="{{ route('cliente.ventas.agregar', $producto->id) }}" method="POST" class="agregar-form">
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

<!-- Modal Carrito -->
<div class="modal fade" id="carritoModal" tabindex="-1" aria-labelledby="carritoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content bg-dark text-white">
            <div class="modal-header">
                <h5 class="modal-title">Tu Carrito</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="carrito-body">
                {{-- Aquí se carga la vista parcial con AJAX --}}
            </div>
            <div class="modal-footer">
                <button class="btn btn-danger" id="vaciar-carrito">Cancelar Compra</button>
                <form action="{{ route('cliente.ventas.confirmar') }}" method="POST" id="confirmar-compra-form">
                    @csrf
                    <button type="submit" class="btn btn-primary">Confirmar Compra</button>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- Estilos --}}
<style>
    body { background-color: #000; }
    h1 { color: white; text-shadow: 0 0 10px #00cfff, 0 0 20px #0077cc; }

    .categorias-trigger { background: transparent; border: none; color: #fff; font-weight: 600; padding: .25rem .5rem; }
    .categorias-trigger:hover { color: #00cfff; text-decoration: none; }
    .dropdown-categorias { position: relative; }
    .categorias-menu { display: none; position: absolute; left: 50%; transform: translateX(-50%); background: #0b0b0b; border: 1px solid #222; border-radius: 12px; padding: 8px 0; min-width: 260px; z-index: 1000; box-shadow: 0 12px 30px rgba(0,0,0,.45); }
    .dropdown-categorias:hover .categorias-menu { display: block; }
    .categorias-menu.show { display: block; }
    .categorias-menu a { display: block; padding: 10px 16px; color: #e5e5e5; font-weight: 500; white-space: nowrap; }
    .categorias-menu a:hover { background: #111827; color: #00cfff; text-decoration: none; }

    .producto-card { background: #fff; border-radius: 12px; box-shadow: 0 2px 15px rgba(0,0,0,0.1); overflow: hidden; transition: 0.3s ease-in-out; }
    .producto-img { width: 100%; height: 200px; object-fit: cover; transition: transform 0.3s ease; }
    .producto-card:hover .producto-img { transform: scale(1.05); }
    .no-img { height: 200px; background-color: #6c757d; color: white; display: flex; align-items: center; justify-content: center; font-weight: bold; border-radius: .375rem .375rem 0 0; }
    .btn-agregar { background-color: #0077cc; border: none; transition: background-color 0.3s; }
    .btn-agregar:hover { background-color: #00cfff; color: black; }
</style>

{{-- Scripts --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    const carritoCount = document.getElementById('carrito-count');
    const carritoBody = document.getElementById('carrito-body');

    // Función para cargar modal
    function cargarCarrito() {
        fetch("{{ route('cliente.ventas.carrito') }}")
            .then(res => res.text())
            .then(html => carritoBody.innerHTML = html);
    }

    // Inicializar modal
    const carritoModal = document.getElementById('carritoModal');
    carritoModal.addEventListener('show.bs.modal', cargarCarrito);

    // Agregar producto
    document.querySelectorAll('.agregar-form').forEach(form => {
        form.addEventListener('submit', e => {
            e.preventDefault();
            fetch(form.action, {
                method: 'POST',
                headers: {'X-CSRF-TOKEN': form.querySelector('input[name=_token]').value},
            })
            .then(res => res.json())
            .then(data => {
                carritoCount.innerText = data.cantidad_total;
                cargarCarrito();
            });
        });
    });

    // Vaciar carrito
    document.getElementById('vaciar-carrito').addEventListener('click', function(){
        fetch("{{ route('cliente.ventas.vaciar') }}", { method: 'POST', headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'} })
            .then(res => res.json())
            .then(data => {
                if(data.status === 'ok'){
                    carritoCount.innerText = 0;
                    cargarCarrito();
                }
            });
    });

    // Delegación para + y - del carrito
    carritoBody.addEventListener('submit', function(e) {
        if (e.target.classList.contains('cantidad-form')) {
            e.preventDefault();
            fetch(e.target.action, {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': e.target.querySelector('input[name=_token]').value }
            })
            .then(res => res.json())
            .then(data => {
                carritoCount.innerText = data.cantidad_total;
                cargarCarrito();
            });
        }
    });
});
</script>
@endsection