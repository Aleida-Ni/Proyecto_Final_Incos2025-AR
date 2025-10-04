@extends('adminlte::page')
@section('title', 'Detalle de Venta')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">Detalle de Venta</h4>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h5>Venta #{{ $venta->codigo }}</h5>
                            <p><strong>Fecha:</strong> {{ $venta->creado_en->format('d/m/Y H:i') }}</p>
                            <p><strong>Realizado por:</strong> 
                                {{ $venta->empleado->nombre ?? 'Usuario no encontrado' }}
                                {{ $venta->empleado->apellido_paterno ?? '' }}
                                ({{ $venta->empleado->rol ?? 'N/A' }})
                            </p>
                            <p><strong>Estado:</strong> {!! $venta->estado_badge !!}</p>
                        </div>
                        <div class="col-md-6 text-end">
                            <h4 class="text-success">Total: Bs. {{ number_format($venta->total, 2) }}</h4>
                            <p><strong>Método de pago:</strong> {{ ucfirst($venta->metodo_pago) }}</p>
                            @if($venta->referencia_pago)
                            <p><strong>Referencia:</strong> {{ $venta->referencia_pago }}</p>
                            @endif
                        </div>
                    </div>

                    <hr>

                    <h6>Productos vendidos</h6>
                    <div class="table-responsive">
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
                                @foreach($venta->detalles as $det)
                                <tr>
                                    <td>{{ $det->producto->nombre }}</td>
                                    <td>Bs. {{ number_format($det->precio, 2) }}</td>
                                    <td>{{ $det->cantidad }}</td>
                                    <td>Bs. {{ number_format($det->subtotal, 2) }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="3" class="text-end">Total:</th>
                                    <th>Bs. {{ number_format($venta->total, 2) }}</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                    <div class="mt-3">
                        <a href="{{ route('admin.ventas.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Volver a la lista
                        </a>
                        @if($venta->estado === 'completada')
                        <form action="{{ route('admin.ventas.destroy', $venta) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('¿Anular esta venta?')">
                                <i class="fas fa-ban"></i> Anular Venta
                            </button>
                        </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection