@extends('cliente.layout')

@section('title', 'Nuestros Barberos')

@section('content')
<h1 class="text-center mb-4">Elige tu barbero</h1>

<div class="d-flex justify-content-between mb-3">
    <!-- Botón: Ver Mis Reservas -->
    <a href="{{ route('cliente.reservas') }}" class="btn btn-custom">
        <i class="fas fa-ticket-alt"></i> Ver Mis Reservas
    </a>

    <!-- Botón: Ver todos los barberos -->
    <a href="{{ route('cliente.barberos.index') }}" class="btn btn-custom">
        <i class="fas fa-users"></i> Ver Todos
    </a>
</div>

<!-- Formulario de filtros (más compacto) -->
<div class="card mb-4 p-3 bg-dark text-white border-0 mx-auto" style="max-width: 900px;">
    <form action="{{ route('cliente.barberos.index') }}" method="GET" class="row g-3 align-items-end">
        <div class="col-md-5">
            <label for="fecha" class="form-label">Selecciona un día</label>
            <div class="input-group">
                <span class="input-group-text bg-black text-white border-0">
                    <i class="fas fa-calendar-alt"></i>
                </span>
                <input type="date" name="fecha" id="fecha" class="form-control bg-black text-white border-0"
                       value="{{ request('fecha') }}">
            </div>
        </div>
        <div class="col-md-5">
            <label for="hora" class="form-label">Selecciona una hora</label>
            <select name="hora" id="hora" class="form-select bg-black text-white border-0">
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
        <div class="col-md-2">
            <button type="submit" class="btn btn-custom w-100">
                <i class="fas fa-search"></i> Buscar
            </button>
        </div>
    </form>
</div>

<!-- Lista de barberos -->
<div class="row">
    @forelse ($barberos as $barbero)
        <div class="col-md-3 mb-4">
            <div class="barbero-card">
                <div class="card-img-container">
                    <img src="{{ asset('storage/' . $barbero->imagen) }}" alt="Foto de {{ $barbero->nombre }}">
                    <div class="overlay">
                        <a href="{{ route('cliente.reservar', $barbero->id) }}" class="btn btn-reservar">Reservar</a>
                    </div>
                </div>
                <div class="info p-3 text-center">
                    <h5>{{ $barbero->nombre }}</h5>
                    <span class="cargo text-muted">{{ $barbero->cargo }}</span>
                </div>
            </div>
        </div>
    @empty
        <p class="text-center text-white">No hay barberos disponibles en esa fecha y hora.</p>
    @endforelse
</div>

<style>
    body {
        background-color: #000000 !important;
    }
    h1 {
        color: white;
    }
    .btn-custom {
        background: none;
        border: none;
        color: white;
        font-weight: bold;
        transition: color 0.3s ease;
    }
    .btn-custom:hover {
        color: #00cfff;
    }
    .form-control, .form-select {
        background-color: #000 !important;
        color: #fff !important;
        border: none !important;
        box-shadow: none !important;
    }
    .input-group-text {
        background-color: #000 !important;
        border: none !important;
        color: #fff !important; /* 👈 icono blanco */
    }
    .barbero-card {
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        transition: 0.3s ease-in-out;
        text-align: center;
    }
    .card-img-container {
        position: relative;
        overflow: hidden;
    }
    .card-img-container img {
        width: 100%;
        height: 280px;
        object-fit: cover;
        transition: transform 0.3s ease;
    }
    .card-img-container:hover img {
        transform: scale(1.05);
    }
    .overlay {
        position: absolute;
        top: 0;
        left: 0;
        height: 100%;
        width: 100%;
        background: rgba(0, 0, 0, 0.5);
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: opacity 0.3s ease;
    }
    .card-img-container:hover .overlay {
        opacity: 1;
    }
    .btn-reservar {
        background-color: #6c63ff;
        color: white;
        padding: 10px 20px;
        border-radius: 30px;
        text-decoration: none;
        font-weight: bold;
    }
</style>
@endsection
