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
                    <th>Nombre</th>
                    <th>Correo</th>
                    <th>Teléfono</th>
                    <th>Fecha Nacimiento</th>
                    <th>Contraseña</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($empleados as $empleado)
                    <tr>
                        <td>{{ $empleado->nombre }} {{ $empleado->apellido_paterno }} {{ $empleado->apellido_materno }}</td>
                        <td>{{ $empleado->correo }}</td>
                        <td>{{ $empleado->telefono }}</td>
                        <td>{{ $empleado->fecha_nacimiento }}</td>
                        <td>
                            <div class="input-group">
                                <input type="password" id="password-{{ $empleado->id }}" 
                                       value="{{ $empleado->contraseña }}" 
                                       class="form-control" readonly>
                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        <i id="toggle-{{ $empleado->id }}" class="fa fa-eye"></i>
                                    </span>
                                </div>
                            </div>
                        </td>
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

@section('js')
<script>
    // Mostrar / ocultar contraseña dinámicamente para cada fila
    document.querySelectorAll('[id^="toggle-"]').forEach(toggle => {
        toggle.addEventListener('click', () => {
            const empleadoId = toggle.id.split('-')[1];
            const input = document.getElementById(`password-${empleadoId}`);
            
            if (input.type === 'password') {
                input.type = 'text';
                toggle.classList.remove('fa-eye');
                toggle.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                toggle.classList.remove('fa-eye-slash');
                toggle.classList.add('fa-eye');
            }
        });
    });
</script>
@stop
