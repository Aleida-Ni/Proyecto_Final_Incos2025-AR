@if(empty($carrito))
    <p class="text-center text-muted">Tu carrito está vacío.</p>
@else
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
                    <td>Bs. {{ number_format($item['precio'],2) }}</td>
                    <td>{{ $item['cantidad'] }}</td>
                    <td>Bs. {{ number_format($item['precio'] * $item['cantidad'],2) }}</td>
                    <td>
                        <div class="d-flex align-items-center">
                            <form action="{{ route('cliente.ventas.disminuir', $id) }}" method="POST" class="cantidad-form me-2">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-outline-danger">-</button>
                            </form>

                            <span class="mx-2">{{ $item['cantidad'] }}</span>

                            <form action="{{ route('cliente.ventas.aumentar', $id) }}" method="POST" class="cantidad-form ms-2">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-outline-success">+</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h4>Total: Bs. {{ number_format($total,2) }}</h4>
@endif
