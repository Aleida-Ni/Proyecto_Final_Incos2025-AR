@extends('cliente.layout')

@section('title', 'Venta')

@section('content')
<div class="container">
    <h1>Productos en la Venta</h1>

    <!-- Botón para volver a la lista de productos -->
    <a href="{{ route('cliente.productos.index') }}" class="btn btn-primary mb-3">
        <i class="fas fa-plus"></i> Agregar Productos
    </a>

    @php
        $carrito = session('carrito', []);
        $cantidad_total = array_sum(array_column($carrito, 'cantidad'));
    @endphp

    <p>Productos en el carrito: <span class="badge badge-danger">{{ $cantidad_total }}</span></p>

    @if(empty($carrito))
        <p>No hay productos en la venta.</p>
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
@endsection
