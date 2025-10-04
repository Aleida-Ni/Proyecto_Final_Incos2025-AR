@extends('adminlte::page')

@section('title', 'Lista de Barberos')

@section('content')
    <h1 class="text-center mb-4 text-dark">Lista de Barberos</h1>

    <div class="table-container mx-auto">
        <a href="{{ route('admin.barberos.create') }}" class="btn btn-custom mb-3">Agregar Barbero</a>

        <table class="table custom-table">
            <thead>
                <tr>
                    <th>Nombre Completo</th> 
                    <th>Correo</th>
                    <th>Teléfono</th>
                    <th>Imagen</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($barberos as $barbero)
                    <tr>
                        <td>{{ $barbero->nombre_completo }}</td> 
                        <td>{{ $barbero->correo }}</td>
                        <td>{{ $barbero->telefono }}</td>
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
.table-container {
    background-color: #f0f0f0; 
    padding: 25px;
    border-radius: 12px;
    box-shadow: 0 8px 20px rgba(0,0,0,0.05);
}

h1.text-dark {
    color: #1c1c1c; 
    text-shadow: 1px 1px 3px rgba(0,0,0,0.15);
}

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

/* Hover de fila */
.custom-table tbody tr:hover {
    background-color: #d0d0d0; 
}

/* Imagen del barbero */
.custom-table img {
    width: 60px; 
    height: auto;
    border-radius: 8px;
    box-shadow: 0 2px 6px rgba(0,0,0,0.1);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.custom-table img:hover {
    transform: scale(1.3); /* agranda al pasar mouse */
    box-shadow: 0 8px 20px rgba(0,0,0,0.3);
}

/* Botones tipo link sin fondo ni borde */
.btn-editar, .btn-eliminar {
    background: none;
    border: none;
    padding: 4px 10px;
    font-weight: 600;
    cursor: pointer;
    position: relative;
    transition: all 0.3s ease;
}

/* Editar: negro con sombras plomo */
.btn-editar {
    color: #1c1c1c;
    text-shadow: 1px 1px 2px #6b6b6b, -1px -1px 2px #6b6b6b;
}

.btn-editar:hover {
    color: #000;
    text-shadow: 2px 2px 6px #7a7a7a, -2px -2px 6px #7a7a7a;
    transform: scale(1.1);
}

/* Eliminar: rojo con sombras rojas */
.btn-eliminar {
    color: #2e2b2bff;
    text-shadow: 1px 1px 2px #c82333, -1px -1px 2px #c82333;
}

.btn-eliminar:hover {
    color: #ff4c4c;
    text-shadow: 2px 2px 6px #e55353, -2px -2px 6px #e55353;
    transform: scale(1.1);
}

/* Formularios (inputs) */
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

    .custom-table img {
        width: 50px;
    }
}
</style>
@endpush

