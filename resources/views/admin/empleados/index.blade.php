@extends('adminlte::page')

@section('title', 'Lista de Empleados')

@section('content_header')
    <h1 class="text-center text-primary" style="text-shadow: 0 0 5px #00aaff, 0 0 10px #00ccff;">
        Lista de Empleados
    </h1>
@stop

@section('content')
    <div class="container">
        <a href="{{ route('admin.empleados.create') }}" class="btn btn-primary mb-3">➕ Nuevo Empleado</a>

        @if(session('success'))
            <div class="alert alert-success text-center">{{ session('success') }}</div>
        @endif
    </div>

    <div class="table-responsive shadow-lg" style="overflow-x:auto;">
        <table class="table table-striped table-hover align-middle text-white" style="background-color: #111; border-radius: 10px; overflow: hidden;">
            <thead style="background: linear-gradient(135deg, #00aaff, #004488);">
                <tr>
                    <th>Nombre completo</th>
                    <th>Correo</th>
                    <th>Teléfono</th>
                    <th>Fecha Nacimiento</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($empleados as $empleado)
                    <tr>
                        <td>
                            {{ $empleado->nombre }}
                            {{ $empleado->apellido_paterno }}
                            {{ $empleado->apellido_materno }}
                        </td>
                        <td>{{ $empleado->correo }}</td>
                        <td>{{ $empleado->telefono }}</td>
                        <td>{{ \Carbon\Carbon::parse($empleado->fecha_nacimiento)->format('d/m/Y') }}</td>
                        <td>
                            <a href="{{ route('admin.empleados.edit', $empleado->id) }}" class="btn btn-warning btn-sm">Editar</a>

                            <form action="{{ route('admin.empleados.destroy', $empleado->id) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm"
                                    onclick="return confirm('¿Seguro que deseas eliminar este empleado?')">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-warning">No hay empleados registrados</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- Estilos extra --}}
<style>
    table tbody tr:hover {
        background: rgba(0, 170, 255, 0.2);
        transform: scale(1.02);
        transition: all 0.3s ease;
    }

    .btn:hover {
        transform: scale(1.05);
        transition: all 0.2s ease;
    }

    table th, table td {
        vertical-align: middle !important;
        text-align: center;
    }

    @media (max-width: 768px) {
        table {
            font-size: 0.9rem;
        }
    }
</style>
@stop
