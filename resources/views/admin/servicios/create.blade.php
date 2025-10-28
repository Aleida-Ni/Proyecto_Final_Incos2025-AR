@extends('adminlte::page')

@section('title', 'Crear Servicio')

@section('content_header')
    <h1><i class="fas fa-plus text-gold"></i> Crear Servicio</h1>
@stop

@section('content')
<div class="container-fluid">
    <div class="card shadow-lg custom-card">
        <div class="card-body">
            <form action="{{ route('admin.servicios.store') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label>Nombre</label>
                    <input type="text" name="nombre" class="form-control" value="{{ old('nombre') }}" required>
                </div>

                <div class="form-group">
                    <label>Descripción</label>
                    <textarea name="descripcion" class="form-control">{{ old('descripcion') }}</textarea>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label>Precio</label>
                        <input type="number" step="0.01" name="precio" class="form-control" value="{{ old('precio', 0) }}" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label>Duración (minutos)</label>
                        <input type="number" name="duracion_minutos" class="form-control" value="{{ old('duracion_minutos', 30) }}" required>
                    </div>
                </div>

                <div class="form-group form-check">
                    <!-- Enviar 0 cuando está desmarcado y 1 cuando está marcado -->
                    <input type="hidden" name="activo" value="0">
                    <input type="checkbox" name="activo" value="1" class="form-check-input" id="activo" checked>
                    <label class="form-check-label" for="activo">Activo</label>
                </div>

                <button class="btn btn-custom">Guardar</button>
                <a href="{{ route('admin.servicios.index') }}" class="btn btn-outline-custom">Cancelar</a>
            </form>
        </div>
    </div>
</div>
@endsection
