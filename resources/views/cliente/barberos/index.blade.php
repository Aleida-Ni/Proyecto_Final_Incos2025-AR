@extends('cliente.layout')

@section('title', 'Nuestros Barberos')

@section('content')
<div class="container my-5">

    <h1 class="text-center mb-4 fw-bold text-dark">Elige tu Barbero</h1>

    <div class="d-flex justify-content-between mb-4 flex-wrap">
        <a href="{{ route('cliente.reservas') }}" class="btn btn-outline-dark mb-2">
            <i class="fas fa-ticket-alt"></i> Mis Reservas
        </a>

        <a href="{{ route('cliente.barberos.index') }}" class="btn btn-outline-dark mb-2">
            <i class="fas fa-users"></i> Ver Todos
        </a>
    </div>

    <!-- Filtro -->
    <div class="card shadow-sm border-0 p-4 mb-5">
        <form action="{{ route('cliente.barberos.index') }}" method="GET" class="row g-3 align-items-end">
            <div class="col-md-5">
                <label for="fecha" class="form-label fw-semibold text-secondary">Selecciona un día</label>
                <div class="input-group">
                    <span class="input-group-text bg-white text-dark border border-end-0">
                        <i class="fas fa-calendar-alt"></i>
                    </span>
                    <input type="date" name="fecha" id="fecha" class="form-control border-start-0"
                           value="{{ request('fecha') }}">
                </div>
            </div>

            <div class="col-md-5">
                <label for="hora" class="form-label fw-semibold text-secondary">Selecciona una hora</label>
                <select name="hora" id="hora" class="form-select">
                    <option value="">-- Selecciona una hora --</option>
                    @php
                        $horas = [
                            '09:00', '10:00', '11:00', '12:00',
                            '13:00', '14:00', '15:00', '16:00', '17:00'
                        ];
                    @endphp
                    @foreach ($horas as $hora)
                        <option value="{{ $hora }}" {{ request('hora') == $hora ? 'selected' : '' }}>
                            {{ $hora }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-2 text-end">
                <button type="submit" class="btn btn-dark w-100 fw-bold">
                    <i class="fas fa-search"></i> Buscar
                </button>
            </div>
        </form>
    </div>

    <!-- Lista de barberos -->
    <div class="row">
        @forelse ($barberos as $barbero)
            <div class="col-md-4 col-lg-3 mb-4">
                <div class="card barbero-card border-0 shadow-sm h-100">
                    <div class="barbero-img-container">
                        <img src="{{ asset('storage/' . $barbero->imagen) }}" class="card-img-top" alt="Foto de {{ $barbero->nombre }}">
                        <div class="barbero-overlay">
                            <a href="{{ route('cliente.reservar', $barbero->id) }}" class="btn btn-reservar">
                                <i class="fas fa-calendar-check me-1"></i> Reservar
                            </a>
                        </div>
                    </div>
                    <div class="card-body text-center">
                        <h5 class="fw-bold text-dark mb-1">{{ $barbero->nombre }}</h5>
                        <small class="text-secondary text-uppercase">{{ $barbero->cargo }}</small>
                    </div>
                </div>
            </div>
        @empty
            <p class="text-center text-muted mt-4">No hay barberos disponibles en esa fecha y hora.</p>
        @endforelse
    </div>
</div>

<style>
    body {
        background-color: #fff !important;
        font-family: 'Poppins', sans-serif;
    }

    .btn-outline-dark {
        border-radius: 25px;
        font-weight: 600;
        transition: 0.3s;
    }
    .btn-outline-dark:hover {
        background-color: #000;
        color: #fff;
    }

    /* Tarjetas de barberos */
    .barbero-card {
        border-radius: 16px;
        transition: all 0.3s ease;
        overflow: hidden;
        position: relative;
    }
    .barbero-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.15);
    }

    .barbero-img-container {
        position: relative;
        overflow: hidden;
    }
    .barbero-img-container img {
        width: 100%;
        height: 280px;
        object-fit: cover;
        transition: transform 0.3s ease;
    }
    .barbero-img-container:hover img {
        transform: scale(1.07);
    }

    .barbero-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.55);
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: opacity 0.3s ease;
    }
    .barbero-img-container:hover .barbero-overlay {
        opacity: 1;
    }

    .btn-reservar {
        background-color: #0d6efd;
        color: #fff;
        border-radius: 30px;
        padding: 10px 22px;
        text-decoration: none;
        font-weight: 600;
        transition: background-color 0.3s ease;
    }
    .btn-reservar:hover {
        background-color: #0b5ed7;
    }

    .form-label {
        font-size: 0.9rem;
    }
</style>

@endsection

@push('js')
<script>
document.querySelector('.input-group-text').addEventListener('click', () => {
    document.getElementById('fecha').focus();
});
</script>
@endpush
