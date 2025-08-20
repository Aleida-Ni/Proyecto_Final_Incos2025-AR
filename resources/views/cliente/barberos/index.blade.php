@extends('cliente.layout')

@section('title', 'Nuestros Barberos')

@section('content')
<h1 class="text-center mb-4">Elige tu barbero</h1>

<div class="d-flex justify-content-end mb-3">
    <a href="{{ route('cliente.reservas') }}" class="btn btn-outline-primary">
        <i class="fas fa-ticket-alt"></i> Ver Mis Reservas
    </a>
</div>

<div class="row">
    @foreach ($barberos as $barbero)
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
    @endforeach
</div>

<style>

        body {
        background-color: #000000 !important;
    }
    .barbero-card {
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        transition: 0.3s ease-in-out;
        text-align: center;
    }

        h1{
            color:white;
            text-shadow: 0 0 10px #00cfff, 0 0 20px #0077cc;

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