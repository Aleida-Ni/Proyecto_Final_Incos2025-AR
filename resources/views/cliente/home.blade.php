@extends('cliente.layout')

@section('title', 'Panel Cliente')

@section('content')
<style>
    body {
        background-color: #000000;
    }

    .custom-hero {
        background-image: url("{{ asset('storage/imagenes/fondocli.jpg') }}");
        background-size: cover;
        background-position: center;
        height: 300px; /* Aquí se define una altura específica */
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        padding-top: 30px;
        padding-bottom: 30px;
    }

    .custom-hero h1 {
        font-size: 3rem;
        font-weight: 700;
        color: #000000ff;
        text-shadow: 0 0 10px #00cfff, 0 0 20px #0077cc;
        margin-bottom: 10px;
    }


.custom-hero p {
    font-size: 1.2rem;
    color: #000;
    backdrop-filter: blur(10px);
    padding: 10px 20px;
    border-radius: 6px;
}


    .custom-hero .btn-blue {
        font-size: 1.1rem;
        padding: 12px 28px;
        background-color: #007bff;
        border: none;
        border-radius: 8px;
        color: white;
        text-decoration: none;
        box-shadow: 0 0 10px #007bff, 0 0 20px #3399ff;
        transition: all 0.3s ease;
    }

    .custom-hero .btn-blue:hover {
        background-color: #0056b3;
        box-shadow: 0 0 20px #3399ff, 0 0 30px #66ccff;
    }
</style>


<div class="custom-hero">
    <div class="hero-content text-center">
        <h1>Transforma tu Estilo</h1>
        <p>Reserva con los mejores barberos y explora nuestros productos exclusivos.</p>
        <a href="{{ route('cliente.barberos.index') }}" class="btn-blue">Reservar</a>
    </div>
</div>

<h3>pie de pagina</h3>
<h3>pie de pagina</h3>

<h3>pie de pagina</h3>

<h3>pie de pagina</h3>

@endsection

@section('js')
<script>
    console.log('Panel de cliente cargado correctamente');
</script>
@endsection