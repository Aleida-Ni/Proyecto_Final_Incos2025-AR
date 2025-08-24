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
<div class="modal fade" id="carritoModal" tabindex="-1" role="dialog" aria-labelledby="carritoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title" id="carritoModalLabel">Carrito de Compras</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Cerrar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                @if(empty($carrito))
                    <p>No hay productos en el carrito.</p>
                @else
                    <form action="{{ route('venta.confirmar') }}" method="POST">
                        @csrf
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Producto</th>
                                    <th>Precio</th>
                                    <th>Cantidad</th>
                                    <th>Subtotal</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $total = 0; @endphp
                                @foreach($carrito as $id => $item)
                                    @php $total += $item['precio'] * $item['cantidad']; @endphp
                                    <tr>
                                        <td>{{ $item['nombre'] }}</td>
                                        <td>Bs. {{ number_format($item['precio'], 2) }}</td>
                                        <td>{{ $item['cantidad'] }}</td>
                                        <td>Bs. {{ number_format($item['precio'] * $item['cantidad'], 2) }}</td>
                                        <td>
                                            <form action="{{ route('cliente.ventas.eliminar', $id) }}" method="POST">
                                                @csrf
                                                <button class="btn btn-danger btn-sm">Eliminar</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <h4>Total: Bs. {{ number_format($total, 2) }}</h4>
                        <button type="submit" class="btn btn-success">Confirmar Compra</button>
                    </form>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
