<form action="{{ route('cliente.ventas.store') }}" method="POST">
    @csrf
    <h3>Selecciona tus productos</h3>
    @foreach ($productos as $producto)
        <div>
            <label>{{ $producto->nombre }} (Stock: {{ $producto->stock }})</label>
            <input type="number" name="productos[{{ $loop->index }}][cantidad]" value="1" min="1">
            <input type="hidden" name="productos[{{ $loop->index }}][id]" value="{{ $producto->id }}">
        </div>
    @endforeach
    <button type="submit">Confirmar Venta</button>
</form>
