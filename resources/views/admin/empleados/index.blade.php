@extends('adminlte::page')

@section('title', 'Lista de Empleados')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="mb-0"><i class="fas fa-users text-gold"></i> Lista de Empleados</h1>
        <a href="{{ route('admin.empleados.create') }}" class="btn btn-custom">
            <i class="fas fa-user-plus mr-2"></i>Nuevo Empleado
        </a>
    </div>
@stop

@section('content')
    <div class="container-fluid">
        <div class="card shadow-lg custom-card">
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success alert-custom text-center">
                        <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-custom text-center">
                        <i class="fas fa-exclamation-circle mr-2"></i>{{ session('error') }}
                    </div>
                @endif

                <div class="table-responsive">
                    <table class="table custom-table table-hover">
                        <thead>
                            <tr>
                                <th width="250px">Nombre completo</th>
                                <th>Correo</th>
                                <th>Teléfono</th>
                                <th>Fecha Nacimiento</th>
                                <th width="150px">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($empleados as $empleado)
                                <tr>
                                    <td class="font-weight-bold text-gris-oscuro">
                                        <i class="fas fa-user-circle text-dorado mr-2"></i>
                                        {{ $empleado->nombre }} {{ $empleado->apellido_paterno }} {{ $empleado->apellido_materno }}
                                    </td>
                                    <td class="text-gris-medio">
                                        <i class="fas fa-envelope text-beige-oscuro mr-2"></i>
                                        {{ $empleado->correo }}
                                    </td>
                                    <td class="text-gris-medio">
                                        <i class="fas fa-phone text-beige-oscuro mr-2"></i>
                                        {{ $empleado->telefono ?? 'N/A' }}
                                    </td>
                                    <td class="text-gris-medio">
                                        <i class="fas fa-birthday-cake text-beige-oscuro mr-2"></i>
                                        {{ $empleado->fecha_nacimiento ? \Carbon\Carbon::parse($empleado->fecha_nacimiento)->format('d/m/Y') : 'N/A' }}
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.empleados.edit', $empleado->id) }}" 
                                               class="btn btn-sm btn-editar"
                                               title="Editar empleado">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            
                                            <form action="{{ route('admin.empleados.destroy', $empleado->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="btn btn-sm btn-eliminar"
                                                        onclick="return confirm('¿Estás seguro de eliminar este empleado?')"
                                                        title="Eliminar empleado">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4">
                                        <div class="empty-state">
                                            <i class="fas fa-users-slash fa-3x text-beige-oscuro mb-3"></i>
                                            <h4 class="text-gris-medio">No hay empleados registrados</h4>
                                            <p class="text-muted">Comienza agregando tu primer empleado al equipo.</p>
                                            <a href="{{ route('admin.empleados.create') }}" class="btn btn-custom mt-2">
                                                <i class="fas fa-user-plus mr-2"></i>Agregar Primer Empleado
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>


            </div>
        </div>
    </div>
@stop

@section('css')
<style>
/* Estilos específicos para empleados */
.empty-state {
    padding: 40px 20px;
}

.alert-custom {
    border: none;
    border-radius: 8px;
    font-weight: 500;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

.alert-success {
    background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
    color: #155724;
    border-left: 4px solid #28a745;
}

.alert-danger {
    background: linear-gradient(135deg, #f8d7da 0%, #f1b0b7 100%);
    color: #721c24;
    border-left: 4px solid #dc3545;
}

/* Mejoras para la tabla de empleados */
.custom-table td {
    vertical-align: middle;
}

/* Responsive */
@media (max-width: 768px) {
    .empty-state {
        padding: 20px 10px;
    }
    
    .empty-state h4 {
        font-size: 1.1rem;
    }
    
    .custom-table {
        font-size: 0.85rem;
    }
    
    .btn-group .btn {
        padding: 4px 8px;
        font-size: 0.8rem;
    }
}

@media (max-width: 576px) {
    .d-flex.justify-content-between.align-items-center {
        flex-direction: column;
        gap: 15px;
    }
    
    .d-flex.justify-content-between.align-items-center h1 {
        text-align: center;
    }
}
</style>
@endsection