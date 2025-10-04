@if(empty($carrito))
    <p class="text-center text-muted">Tu carrito está vacío.</p>
@else
    <table class="table table-dark table-striped align-middle">
        <thead>
            <tr>
                <th>Producto</th>
                <th style="width:140px">Cantidad</th>
                <th>Precio</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @php $total = 0; @endphp
            @foreach($carrito as $id => $item)
                @php $subtotal = $item['precio'] * $item['cantidad']; $total += $subtotal; @endphp
                <tr>
                    <td>{{ $item['nombre'] }}</td>
                    <td class="text-center">
                        <button class="btn btn-sm btn-outline-light btn-disminuir" data-url="{{ route('cliente.ventas.disminuir', $id) }}">-</button>
                        <span class="mx-2">{{ $item['cantidad'] }}</span>
                        <button class="btn btn-sm btn-outline-light btn-aumentar" data-url="{{ route('cliente.ventas.aumentar', $id) }}">+</button>
                    </td>
                    <td>Bs. {{ number_format($item['precio'], 2) }}</td>
                    <td>Bs. {{ number_format($subtotal, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th colspan="3" class="text-end">Total:</th>
                <th>Bs. {{ number_format($total, 2) }}</th>
            </tr>
        </tfoot>
    </table>
@endif
