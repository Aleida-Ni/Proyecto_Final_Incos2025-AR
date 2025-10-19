@extends('adminlte::page')

@section('title', 'Lista de Barberos')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="mb-0"><i class="fas fa-user-scissors text-gold"></i> Lista de Barberos</h1>
        <a href="{{ route('admin.barberos.create') }}" class="btn btn-custom">
            <i class="fas fa-plus"></i> Agregar Barbero
        </a>
    </div>
@stop

@section('content')
    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table custom-table table-hover">
                    <thead>
                        <tr>
                            <th width="70px">Imagen</th>
                            <th>Nombre Completo</th> 
                            <th>Correo</th>
                            <th>Teléfono</th>
                            <th width="150px">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($barberos as $barbero)
                            <tr>
                                <td>
                                    @if($barbero->imagen)
                                        <img src="{{ asset('storage/' . $barbero->imagen) }}" 
                                             class="img-square"
                                             alt="Imagen de {{ $barbero->nombre_completo }}"
                                             title="{{ $barbero->nombre_completo }}">
                                    @else
                                        <div class="img-placeholder" title="Sin imagen">
                                            <i class="fas fa-user"></i>
                                        </div>
                                    @endif
                                </td>
                                <td class="font-weight-bold text-gris-oscuro">{{ $barbero->nombre_completo }}</td> 
                                <td class="text-gris-medio">{{ $barbero->correo }}</td>
                                <td class="text-gris-medio">{{ $barbero->telefono }}</td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('admin.barberos.edit', $barbero->id) }}" 
                                           class="btn btn-sm btn-editar" 
                                           title="Editar barbero">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        
                                        <form action="{{ route('admin.barberos.destroy', $barbero->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="btn btn-sm btn-eliminar"
                                                    onclick="return confirm('¿Estás seguro de eliminar este barbero?')"
                                                    title="Eliminar barbero">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            @if($barberos->isEmpty())
                <div class="text-center py-5">
                    <i class="fas fa-user-slash fa-3x text-beige-oscuro mb-3"></i>
                    <h4 class="text-gris-medio">No hay barberos registrados</h4>
                    <p class="text-muted">Comienza agregando tu primer barbero al equipo.</p>
                </div>
            @endif
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="{{ asset('css/custom-adminlte.css') }}">
    <style>
        /* Estilos adicionales para imágenes cuadradas */
        .img-square {
            width: 60px;
            height: 60px;
            border-radius: 8px;
            object-fit: cover;
            border: 2px solid #e8e4d5;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
        }

        .img-square:hover {
            transform: scale(1.1);
            border-color: #D4AF37;
            box-shadow: 0 4px 12px rgba(212, 175, 55, 0.3);
        }

        .img-placeholder {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, #F5F5DC 0%, #E8E4D5 100%);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 2px dashed #F4E4A8;
            color: #4A4A4A;
            font-size: 1.2rem;
            transition: all 0.3s ease;
        }

        .img-placeholder:hover {
            background: linear-gradient(135deg, #F4E4A8 0%, #F5F5DC 100%);
            border-color: #D4AF37;
            color: #D4AF37;
            transform: scale(1.05);
        }

        /* Ajustes responsivos */
        @media (max-width: 768px) {
            .img-square, .img-placeholder {
                width: 50px;
                height: 50px;
            }
            
            .custom-table th:nth-child(1),
            .custom-table td:nth-child(1) {
                width: 60px;
            }
        }
    </style>
@stop

@section('js')
    <script>
        $(document).ready(function() {
            // Efecto hover para las filas
            $('.custom-table tbody tr').hover(
                function() {
                    $(this).addClass('shadow-sm');
                    $(this).find('.img-square').css('transform', 'scale(1.05)');
                },
                function() {
                    $(this).removeClass('shadow-sm');
                    $(this).find('.img-square').css('transform', 'scale(1)');
                }
            );

            // Tooltips para las imágenes
            $('.img-square, .img-placeholder').tooltip({
                trigger: 'hover',
                placement: 'top'
            });
        });
    </script>
@stop