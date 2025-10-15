@extends('adminlte::page')

@section('title', 'Reportes - Productos')

@section('content_header')
    <h1>Productos más vendidos</h1>
@stop

@section('content')
<div class="card">
    <div class="card-body">
        <div class="d-flex justify-content-between mb-3">
            <h5 class="mb-0">Top productos</h5>
            <div class="btn-group">
                <a href="#" class="btn btn-danger btn-sm"><i class="fas fa-file-pdf"></i> PDF</a>
                <a href="#" class="btn btn-success btn-sm"><i class="fas fa-file-excel"></i> Excel</a>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Precio</th>
                        <th>Vendidos</th>
                        <th>Ingreso Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($productos as $p)
                    <tr>
                        <td>{{ $p->id }}</td>
                        <td>{{ $p->nombre }}</td>
                        <td>Bs. {{ number_format($p->precio, 2) }}</td>
                        <td>{{ $p->total_vendido }}</td>
                        <td>Bs. {{ number_format($p->ingreso_total, 2) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{ $productos->links() }}
    </div>
</div>
@stop
