@extends('adminlte::page')

@section('title', 'Lista de Empleados')

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
/* ======== CONTENEDOR PRINCIPAL ======== */
.table-container {
    background-color: #f9f9f9; /* Fondo claro */
    padding: 25px;
    border-radius: 16px;
    box-shadow: 0 8px 24px rgba(0,0,0,0.08);
}

/* ======== TÍTULO ======== */
.title-shadow {
    font-weight: 700;
    color: #1c1c1c;
    text-shadow: 1px 1px 3px rgba(0,0,0,0.15);
    letter-spacing: 1px;
}

/* ======== BOTÓN NUEVO EMPLEADO ======== */
.btn-custom {
    background-color: #4a4a4a;
    color: #fff;
    border-radius: 6px;
    padding: 8px 16px;
    font-weight: 600;
    transition: all 0.3s ease;
    box-shadow: 0 3px 8px rgba(0,0,0,0.3);
}

.btn-custom:hover {
    background-color: #333;
    transform: translateY(-2px);
    box-shadow: 0 6px 12px rgba(0,0,0,0.35);
}

/* ======== TABLA ======== */
.custom-table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
    border-radius: 12px;
    overflow: hidden;
    background-color: #ffffff;
    box-shadow: 0 4px 12px rgba(0,0,0,0.05);
}

.custom-table thead {
    background-color: #dcdcdc;
}

.custom-table th, .custom-table td {
    padding: 12px 15px;
    text-align: center;
    vertical-align: middle;
    color: #1c1c1c;
    border-bottom: 1px solid #bfbfbf;
}

.custom-table tbody tr:hover {
    background-color: #efefef;
}

/* ======== BOTONES EDITAR Y ELIMINAR ======== */
.btn-editar, .btn-eliminar {
    background: none;
    border: none;
    padding: 5px 10px;
    font-weight: 600;
    cursor: pointer;
    position: relative;
    transition: all 0.3s ease;
}

/* Editar: gris oscuro con efecto moderno */
.btn-editar {
    color: #222;
}

.btn-editar:hover {
    color: #000;
    text-shadow: 0 0 8px rgba(100,100,100,0.4);
    transform: scale(1.05);
}

/* Eliminar: rojo elegante con transición */
.btn-eliminar {
    color: #c9302c;
}

.btn-eliminar:hover {
    color: #ff4d4d;
    text-shadow: 0 0 8px rgba(255,0,0,0.4);
    transform: scale(1.05);
}

/* ======== CAMPOS DE FORMULARIO ======== */
input, select, textarea {
    border: 1px solid #ccc;
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

/* ======== RESPONSIVE ======== */
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
