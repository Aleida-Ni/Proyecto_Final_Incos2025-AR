@extends('cliente.layout')

@section('title', 'Venta')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Productos en la Venta</h1>

        @php
            $carrito = session('carrito', []);
            $cantidad_total = array_sum(array_column($carrito, 'cantidad'));
        @endphp

        <!-- Botón carrito -->
        <button type="button" class="btn btn-primary position-relative" data-toggle="modal" data-target="#carritoModal">
            <i class="fas fa-shopping-cart"></i>
            @if($cantidad_total > 0)
                <span class="badge badge-danger position-absolute top-0 start-100 translate-middle">
                    {{ $cantidad_total }}
                </span>
            @endif
        </button>
    </div>

    <!-- Botón para volver a la lista de productos -->
    <a href="{{ route('cliente.productos.index') }}" class="btn btn-success mb-3">
        <i class="fas fa-plus"></i> Agregar Productos
    </a>
</div>

<!-- Modal Carrito -->
<div class="modal fade" id="modalConfirmarCompra" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content bg-dark text-white">
            <div class="modal-header">
                <h5 class="modal-title">Confirmar Compra</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center">
                <h4>Pedido Pendiente</h4>
                <p>Total: ${{ $venta->total }}</p>

                <h5>Escanea el QR para confirmar o guardar</h5>
                <img src="data:image/png;base64,{{ $qr }}" alt="QR de la venta" class="mb-3">

                <h5>Comprobante de pago</h5>
                <p>Pago pendiente. Una vez confirmado, tu pedido será procesado.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>
                <form action="{{ route('cliente.ventas.confirmar_pago', $venta->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-primary">Confirmar Compra</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
