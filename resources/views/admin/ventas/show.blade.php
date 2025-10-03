<h5>Venta #{{ $venta->id }}</h5>
<p><strong>Fecha:</strong> {{ $venta->creado_en }}</p>
<p><strong>Total:</strong> Bs. {{ number_format($venta->total, 2) }}</p>

<hr>
<h6>Detalle de productos</h6>
<ul>
    @foreach($venta->detalles as $det)
        <li>{{ $det->producto->nombre }} — {{ $det->cantidad }} x Bs. {{ number_format($det->precio,2) }}</li>
    @endforeach
</ul>
