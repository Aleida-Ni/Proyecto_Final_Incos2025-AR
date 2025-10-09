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
    background-color: #ffffff; 
    padding: 25px;
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.08);
    border: 1px solid #e0e0e0;
}

h1.text-dark {
    color: #2c3e50; 
    font-weight: 600;
    letter-spacing: -0.5px;
}

.btn-custom {
    background-color: #2c3e50; 
    color: #fff;
    border-radius: 6px;
    padding: 8px 16px;
    font-weight: 500;
    transition: all 0.3s ease;
    border: none;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.btn-custom:hover {
    background-color: #34495e; 
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.15);
}

.custom-table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
    border-radius: 8px;
    overflow: hidden;
    background-color: #ffffff;
    box-shadow: 0 2px 8px rgba(0,0,0,0.04);
}

.custom-table thead {
    background-color: #f8f9fa; 
    border-bottom: 2px solid #e9ecef;
}

.custom-table th {
    font-weight: 600;
    color: #495057;
    padding: 14px 15px;
    text-align: center;
    vertical-align: middle;
    border-bottom: 2px solid #e9ecef;
}

.custom-table td {
    padding: 12px 15px;
    text-align: center;
    vertical-align: middle;
    color: #6c757d;
    border-bottom: 1px solid #f1f3f4;
}

.custom-table tbody tr {
    transition: all 0.2s ease;
}

.custom-table tbody tr:hover {
    background-color: #f8f9fa;
    transform: translateY(-1px);
    box-shadow: 0 2px 6px rgba(0,0,0,0.05);
}

.custom-table img {
    width: 60px;
    height: 60px;
    border-radius: 8px;
    object-fit: cover;
    box-shadow: 0 2px 6px rgba(0,0,0,0.1);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.custom-table img:hover {
    transform: scale(1.3);
    box-shadow: 0 8px 20px rgba(0,0,0,0.2);
}

.btn-editar, .btn-eliminar {
    border: none;
    border-radius: 4px;
    padding: 6px 12px;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.3s ease;
    font-size: 0.85rem;
    margin: 2px;
}

.btn-editar {
    background-color: #3498db;
    color: white;
    box-shadow: 0 1px 3px rgba(52, 152, 219, 0.3);
}

.btn-editar:hover {
    background-color: #2980b9;
    transform: translateY(-1px);
    box-shadow: 0 3px 6px rgba(52, 152, 219, 0.4);
}

.btn-eliminar {
    background-color: #e74c3c;
    color: white;
    box-shadow: 0 1px 3px rgba(231, 76, 60, 0.3);
}

.btn-eliminar:hover {
    background-color: #c0392b;
    transform: translateY(-1px);
    box-shadow: 0 3px 6px rgba(231, 76, 60, 0.4);
}

@media (max-width: 768px) {
    .table-container {
        padding: 15px;
    }
    
    .custom-table th, .custom-table td {
        padding: 8px 10px;
        font-size: 0.9rem;
    }

    .btn-custom {
        padding: 6px 12px;
        font-size: 0.9rem;
    }

    .btn-editar, .btn-eliminar {
        padding: 4px 8px;
        font-size: 0.8rem;
    }

    .custom-table img {
        width: 50px;
        height: 50px;
    }
}
</style>
@endpush