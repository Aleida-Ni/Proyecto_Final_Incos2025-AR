@extends('adminlte::page')

@section('title', 'Lista de Barberos')

@section('content')
    <h1 class="text-center mb-4 text-dark">Lista de Barberos</h1>

    <div class="table-container mx-auto">
        <a href="{{ route('admin.barberos.create') }}" class="btn btn-custom mb-3">Agregar Barbero</a>

        <table class="table custom-table">
            <thead>
                <tr>
                    <th>Nombre Completo</th> {{-- Cambié encabezado --}}
                    <th>Correo</th>
                    <th>Teléfono</th>
                    <th>Cargo</th>
                    <th>Imagen</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($barberos as $barbero)
                    <tr>
                        <td>{{ $barbero->nombre_completo }}</td> {{-- Usamos accesor --}}
                        <td>{{ $barbero->correo }}</td>
                        <td>{{ $barbero->telefono }}</td>
                        <td>{{ $barbero->cargo }}</td>
                        <td>
                            @if($barbero->imagen)
                                <img src="{{ asset('storage/' . $barbero->imagen) }}" width="80" alt="Imagen del barbero">
                            @else
                                Sin imagen
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('admin.barberos.edit', $barbero->id) }}" class="btn btn-sm btn-editar">Editar</a>

                            <form action="{{ route('admin.barberos.destroy', $barbero->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-eliminar" onclick="return confirm('¿Seguro?')">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection

@push('css')
<style>
    h1.text-dark {
        color: #000 !important;
    }

    .btn-custom {
        background-color: #343a40;
        color: white;
        border: none;
    }

    .btn-custom:hover {
        background-color: #23272b;
    }

    .btn-editar {
        background-color: #007bff;
        color: white;
    }

    .btn-editar:hover {
        background-color: #0056b3;
    }

    .btn-eliminar {
        background-color: #dc3545;
        color: white;
    }

    .btn-eliminar:hover {
        background-color: #bd2130;
    }

    .custom-table {
        background-color: white;
        border-radius: 8px;
        overflow: hidden;
    }
</style>
@endpush
