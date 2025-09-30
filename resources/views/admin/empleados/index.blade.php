@extends('adminlte::page')

@section('title', 'Lista de Empleados')
@section('css')
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
@endsection

@section('content_header')
    <h1 class="text-center text-dark title-shadow">Lista de Empleados</h1>
@stop

@section('content')
    <div class="container table-container">
        <a href="{{ route('admin.empleados.create') }}" class="btn btn-custom mb-3"> Nuevo Empleado</a>

        @if(session('success'))
            <div class="alert alert-success text-center">{{ session('success') }}</div>
        @endif

        <div class="table-responsive shadow-lg" style="overflow-x:auto;">
            <table class="table custom-table">
                <thead>
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
                            <td>{{ $empleado->nombre }} {{ $empleado->apellido_paterno }} {{ $empleado->apellido_materno }}</td>
                            <td>{{ $empleado->correo }}</td>
                            <td>{{ $empleado->telefono }}</td>
                            <td>{{ \Carbon\Carbon::parse($empleado->fecha_nacimiento)->format('d/m/Y') }}</td>
                            <td>
                                <a href="{{ route('admin.empleados.edit', $empleado->id) }}" class="btn-editar">Editar</a>

                                <form action="{{ route('admin.empleados.destroy', $empleado->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-eliminar"
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
@stop

@push('css')
<style>
/* Contenedor */
.table-container {
    background-color: #f0f0f0; /* plomo claro */
    padding: 25px;
    border-radius: 12px;
    box-shadow: 0 8px 20px rgba(0,0,0,0.05);
}

/* Título */
.title-shadow {
    color: #1c1c1c;
    text-shadow: 1px 1px 3px rgba(0,0,0,0.15);
}

/* Botón nuevo */
.btn-custom {
    background-color: #4a4a4a;
    color: #fff;
    border-radius: 6px;
    padding: 6px 14px;
    font-weight: 600;
    transition: all 0.3s ease;
    box-shadow: 0 2px 6px rgba(0,0,0,0.3);
}

.btn-custom:hover {
    background-color: #333;
    transform: translateY(-2px);
    box-shadow: 0 6px 12px rgba(0,0,0,0.4);
}

/* Tabla */
.custom-table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
    border-radius: 12px;
    overflow: hidden;
    background-color: #e8e8e8;
    box-shadow: 0 4px 12px rgba(0,0,0,0.05);
}

.custom-table thead {
    background-color: #c2c2c2;
}

.custom-table th, .custom-table td {
    padding: 12px 15px;
    text-align: center;
    vertical-align: middle;
    color: #1c1c1c;
    border-bottom: 1px solid #b0b0b0;
}

.custom-table tbody tr:hover {
    background-color: #d0d0d0;
}

/* Botones tipo link */
.btn-editar, .btn-eliminar {
    background: none;
    border: none;
    padding: 4px 10px;
    font-weight: 600;
    cursor: pointer;
    position: relative;
    transition: all 0.3s ease;
}

/* Editar: negro con sombra plomo */
.btn-editar {
    color: #1c1c1c;
}

.btn-editar:hover {
    color: #000;
    text-shadow: 2px 2px 6px #7a7a7a, -2px -2px 6px #7a7a7a;
    transform: scale(1.1);
}

/* Eliminar: rojo con sombra roja */
.btn-eliminar {
    color: #d42727ff;
}

.btn-eliminar:hover {
    color: #ff4c4c;
    text-shadow: 2px 2px 6px #e55353, -2px -2px 6px #e55353;
    transform: scale(1.1);
}

/* Formularios */
input, select, textarea {
    border: 1px solid #333;
    border-radius: 6px;
    padding: 6px 10px;
    background-color: #fff;
    color: #1c1c1c;
    transition: 0.3s;
}

input:focus, select:focus, textarea:focus {
    border-color: #000;
    box-shadow: 0 0 6px rgba(0,0,0,0.3);
    outline: none;
}

/* Responsive */
@media (max-width: 768px) {
    .custom-table th, .custom-table td {
        padding: 8px 10px;
    }

    .btn-custom, .btn-editar, .btn-eliminar {
        padding: 4px 8px;
        font-size: 0.9rem;
    }
}
</style>
@endpush
