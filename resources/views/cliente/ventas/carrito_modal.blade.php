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
                @php $total += $item['precio'] * $item['cantidad']; @endphp
                <tr>
                    <td>{{ $item['nombre'] }}</td>
                    <td class="text-center">
                        <button class="btn btn-sm btn-outline-light btn-disminuir" data-id="{{ $id }}">-</button>
                        <span class="mx-2 cantidad-{{ $id }}">{{ $item['cantidad'] }}</span>
                        <button class="btn btn-sm btn-outline-light btn-aumentar" data-id="{{ $id }}">+</button>
                    </td>
                    <td>Bs. {{ number_format($item['precio'], 2) }}</td>
                    <td>Bs. {{ number_format($item['precio'] * $item['cantidad'], 2) }}</td>
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
