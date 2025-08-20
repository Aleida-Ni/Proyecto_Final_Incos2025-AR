@extends('adminlte::page')

@section('title', 'Lista de Empleados')

@section('content_header')
    <h1 class="text-center">Lista de Empleados</h1>
@stop

@section('content')
    <div class="container">
<a href="{{ route('admin.empleados.create') }}" class="btn btn-primary mb-3">➕ Nuevo Empleado</a>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <table class="table table-bordered table-striped">
            <thead class="bg-dark text-white">
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Teléfono</th>
                    <th>Fecha Nacimiento</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($empleados as $empleado)
                    <tr>
                        <td>{{ $empleado->id }}</td>
                        <td>{{ $empleado->name }}</td>
                        <td>{{ $empleado->email }}</td>
                        <td>{{ $empleado->telefono }}</td>
                        <td>{{ $empleado->fecha_nacimiento }}</td>
                        <td>
                            <a href="{{ route('admin.empleados.edit', $empleado->id) }}" class="btn btn-warning btn-sm">✏ Editar</a>

                            <form action="{{ route('admin.empleados.destroy', $empleado->id) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm"
                                    onclick="return confirm('¿Seguro que deseas eliminar este empleado?')">🗑 Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">No hay empleados registrados</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@stop
