@extends('cliente.layout')
@section('content')
<div class="container">
    <h2>Pago - Pedido {{ $venta->codigo }}</h2>

    <p>Total: Bs. {{ number_format($venta->total,2) }}</p>

    <div class="mb-4">
        <p>Escanea este QR para realizar el pago:</p>
        <img src="{{ asset('storage/'.$venta->qr) }}" alt="QR de pago" class="img-fluid" style="max-width:320px;">
    </div>

    @if($venta->comprobante)
        <p>Comprobante subido: <a target="_blank" href="{{ asset('storage/'.$venta->comprobante) }}">ver comprobante</a></p>
    @else
        <form action="{{ route('cliente.ventas.comprobante', $venta->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label>Subir comprobante (jpg/png/pdf)</label>
                <input type="file" name="comprobante" required accept="image/*,application/pdf" class="form-control">
            </div>
            <button class="btn btn-primary">Subir comprobante</button>
        </form>
    @endif
</div>
@endsection
