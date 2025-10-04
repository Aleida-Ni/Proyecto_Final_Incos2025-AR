@extends('adminlte::page')

@section('title', 'Lista de Ventas')
@section('css')
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
@endsection
@section('content_header')
    <h1>Ventas</h1>
@stop

@section('content')
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="card">
        <div class="card-header">
            <a href="{{ route('admin.ventas.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Nueva Venta
            </a>
        </div>
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Código</th>
                        <th>Fecha</th>
                        <th>Realizado por</th>
                        <th>Total</th>
                        <th>Estado</th>
                        <th>Método Pago</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($ventas as $venta)
                    <tr>
                        <td>{{ $venta->codigo ?? 'N/A' }}</td>
                        <td>{{ $venta->fecha_formateada ?? 'N/A' }}</td>
                        <td>
                            {{ $venta->empleado->nombre ?? 'Usuario no encontrado' }}
                            {{ $venta->empleado->apellido_paterno ?? '' }}
                            <br>
                            <small class="text-muted">{{ $venta->empleado->rol ?? '' }}</small>
                        </td>
                        <td>{{ $venta->total_formateado ?? '$ 0.00' }}</td>
                        <td>{!! $venta->estado_badge ?? '<span class="badge badge-secondary">N/A</span>' !!}</td>
                        <td>{{ ucfirst($venta->metodo_pago ?? 'efectivo') }}</td>
                        <td>
                            <a href="{{ route('admin.ventas.show', $venta) }}" class="btn btn-info btn-sm">
                                <i class="fas fa-eye"></i>
                            </a>
                            @if(($venta->estado ?? 'completada') === 'completada')
                            <form action="{{ route('admin.ventas.destroy', $venta) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Anular esta venta?')">
                                    <i class="fas fa-ban"></i>
                                </button>
                            </form>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            
            <div class="mt-4">
                {{ $ventas->links() }}
            </div>
        </div>
    </div>
@stop