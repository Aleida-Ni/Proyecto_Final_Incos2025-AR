@extends('cliente.layout')

@section('title', 'Compra Exitosa')

@section('content')
<div class="container">
    <h1>Compra Confirmada</h1>
    <p>¡Gracias por tu compra!</p>
    <p><strong>Código de Pedido:</strong> {{ $venta->codigo }}</p>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>Producto</th>
                <th>Precio</th>
                <th>Cantidad</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($venta->detalles as $detalle)
                <tr>
                    <td>{{ $detalle->producto->nombre }}</td>
                    <td>Bs. {{ number_format($detalle->producto->precio, 2) }}</td>
                    <td>{{ $detalle->cantidad }}</td>
                    <td>Bs. {{ number_format($detalle->subtotal, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h4>Total: Bs. {{ number_format($venta->total, 2) }}</h4>

    <a href="{{ route('cliente.productos.index') }}" class="btn btn-primary">Seguir Comprando</a>
</div>
@endsection
