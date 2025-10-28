@extends('adminlte::page')

@section('title', 'Servicios')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="mb-0"><i class="fas fa-scissors text-gold"></i> Servicios</h1>
        <a href="{{ route('admin.servicios.create') }}" class="btn btn-custom">
            <i class="fas fa-plus mr-2"></i>Agregar Servicio
        </a>
    </div>
@stop

@section('content')
<div class="container-fluid">
    <div class="card shadow-lg custom-card">
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success text-center">{{ session('success') }}</div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger text-center">{{ session('error') }}</div>
            @endif

            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Precio</th>
                            <th>Duración (min)</th>
                            <th>Activo</th>
                            <th width="140px">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($servicios as $servicio)
                            <tr>
                                <td class="font-weight-bold">{{ $servicio->nombre }}</td>
                                <td class="text-success">{{ number_format($servicio->precio, 2) }} Bs</td>
                                <td>{{ $servicio->duracion_minutos }}</td>
                                <td>
                                    @if($servicio->activo)
                                        <span class="badge badge-success">Sí</span>
                                    @else
                                        <span class="badge badge-secondary">No</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('admin.servicios.edit', $servicio->id) }}" class="btn btn-sm btn-editar" title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.servicios.destroy', $servicio->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-eliminar" onclick="return confirm('¿Seguro que quieres eliminar este servicio?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-4">
                                    No hay servicios registrados.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
