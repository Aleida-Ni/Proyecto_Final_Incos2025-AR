@extends('adminlte::page')

@section('title', 'Ventas')

@section('content')
<div class="d-flex justify-content-between mb-3">
    <h1>Ventas</h1>
    <a href="{{ route('admin.ventas.create') }}" class="btn btn-primary">Registrar Nueva Venta</a>
</div>

<table class="table table-striped">
    <thead>
        <tr>
            <th>ID</th>
            <th>Fecha</th>
            <th>Total</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach($ventas as $venta)
        <tr>
            <td>{{ $venta->id }}</td>
            <td>{{ $venta->creado_en }}</td>
            <td>Bs. {{ number_format($venta->total, 2) }}</td>
            <td>
                <button class="btn btn-info btn-sm" 
                        data-bs-toggle="modal" 
                        data-bs-target="#modalVenta" 
                        data-venta="{{ $venta->id }}">
                    Ver
                </button>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

{{ $ventas->links() }}

{{-- Modal de Ticket --}}
<div class="modal fade" id="modalVenta" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Ticket de Venta</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="modal-venta-body">
                Cargando...
            </div>
        </div>
    </div>
</div>

@endsection

@section('js')
<script>
document.addEventListener('DOMContentLoaded', function() {
    var modal = document.getElementById('modalVenta');
    modal.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget;
        var ventaId = button.getAttribute('data-venta');
        var modalBody = document.getElementById('modal-venta-body');

        modalBody.innerHTML = 'Cargando...';

        fetch(`/admin/ventas/${ventaId}`)
            .then(res => res.text())
            .then(html => {
                modalBody.innerHTML = html;
            });
    });
});
</script>
@endsection
