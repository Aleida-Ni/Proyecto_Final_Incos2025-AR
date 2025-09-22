@extends('cliente.layout')

@section('title', 'Panel Cliente')

@push('css')
<!-- Swiper CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css" />

<style>
    body {
        background-color: #000;
    }

    /* === Hero === */
    .custom-hero {
        background-image: url("{{ asset('imagenes/homeCliente/fondoCliente1.jpg') }}");
        background-size: cover;
        background-position: center;
        height: 350px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        padding: 30px 0;
        text-align: center;
    }

    .custom-hero h1 {
        font-size: 3rem;
        font-weight: 700;
        color: #fff;
        text-shadow: 0 0 10px #000;
        margin-bottom: 10px;
    }

    .custom-hero p {
        font-size: 1.2rem;
        color: #f1f1f1;
        background: rgba(0,0,0,0.4);
        padding: 10px 20px;
        border-radius: 6px;
        display: inline-block;
    }

    .custom-hero .btn-blue {
        font-size: 1.1rem;
        padding: 12px 28px;
        background: #007bff;
        border-radius: 8px;
        color: #fff;
        box-shadow: 0 0 10px #007bff, 0 0 20px #3399ff;
        text-decoration: none;
        transition: all .3s;
        margin-top: 15px;
    }

    .custom-hero .btn-blue:hover {
        background: #0056b3;
    }

    /* === Swiper === */
    :root {
        --slide-width: 480px;
        --slide-height: 320px;
    }

    .swiper {
        width: 100%;
        max-width: 1200px;
        margin: 3rem auto;
        padding: 0 40px;
    }

    .swiper-slide {
        width: var(--slide-width);
        height: var(--slide-height);
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
        transition: transform 0.4s ease;
    }

    .slide-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 28px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.6);
        transition: transform .45s cubic-bezier(.22, .9, .33, 1);
    }

    /* Efecto zoom en el slide activo */
    .swiper-slide-active .slide-img {
        transform: scale(1.12);
    }

    .slide-caption {
        position: absolute;
        left: 20px;
        bottom: 18px;
        color: #fff;
        font-weight: 700;
        text-shadow: 0 3px 12px rgba(0, 0, 0, 0.6);
    }

    /* controles */
    .swiper-button-next,
    .swiper-button-prev {
        color: #fff;
        width: 48px;
        height: 48px;
        border-radius: 50%;
        background: rgba(0, 0, 0, 0.35);
        box-shadow: 0 0 18px rgba(0, 207, 255, 0.12);
    }

    /* bullets */
    .swiper-pagination-bullet {
        background: rgba(102, 204, 255, 0.6);
        opacity: 1;
    }

    .swiper-pagination-bullet-active {
        background: #00cfff;
        transform: scale(1.05);
        box-shadow: 0 0 10px #00cfff;
    }

    /* sparkles */
    .sparkle-overlay {
        position: absolute;
        inset: 0;
        border-radius: 28px;
        pointer-events: none;
        background-image:
            radial-gradient(2px 2px at 18% 26%, rgba(255, 255, 255, .9), rgba(255, 255, 255, 0)),
            radial-gradient(1.8px 1.8px at 68% 64%, rgba(0, 207, 255, .95), rgba(0, 207, 255, 0)),
            radial-gradient(1.6px 1.6px at 40% 82%, rgba(51, 153, 255, .9), rgba(51, 153, 255, 0)),
            radial-gradient(1.4px 1.4px at 85% 22%, rgba(255, 255, 255, .95), rgba(255, 255, 255, 0));
        background-repeat: no-repeat;
        opacity: .55;
        animation: twinkle 4.2s ease-in-out infinite;
    }

    @keyframes twinkle {
        0% { opacity: .2; transform: translateY(0) scale(1); }
        50% { opacity: .95; transform: translateY(-2px) scale(1.02); }
        100% { opacity: .2; transform: translateY(0) scale(1); }
    }

    /* Tarjetas rápidas */
    .option-card {
        border-radius: 15px;
        transition: transform 0.2s, box-shadow 0.2s;
        cursor: pointer;
        padding: 25px 20px;
    }
    .option-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.3);
    }

    /* responsive */
    @media (max-width: 992px) {
        :root {
            --slide-width: 360px;
            --slide-height: 240px;
        }
    }
    @media (max-width: 576px) {
        :root {
            --slide-width: 260px;
            --slide-height: 180px;
        }
    }
      /* Tarjetas de productos */
    .product-card {
        border-radius: 15px;
        overflow: hidden;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .product-card img {
        height: 250px;
        object-fit: cover;
        transition: transform 0.3s ease;
    }
    .product-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.5);
    }
    .product-card:hover img {
        transform: scale(1.05);
    }
    .product-card .card-body {
        background-color: #111;
        color: #fff;
    }
</style>
@endpush

@section('content')

<!-- HERO -->
<div class="custom-hero">
    <div class="hero-content text-center">
        <h1>Transforma tu Estilo</h1>
        <p>Reserva con los mejores barberos y explora nuestros productos exclusivos.</p>
        <a href="{{ route('cliente.barberos.index') }}" class="btn-blue">Reservar</a>
    </div>
</div>

<!-- PRODUCTOS DESTACADOS -->
<div class="container my-5">
    <h2 class="text-center text-white mb-4">Productos Destacados</h2>

    <div class="row justify-content-center">
        <!-- Tarjeta 1 -->
        <div class="col-md-4 col-sm-6 mb-4">
            <div class="card product-card h-100 shadow-sm">
                <img src="{{ asset('imagenes/homeCliente/productoLogin1.jpeg') }}" class="card-img-top" alt="Producto 1">
                <div class="card-body text-center">
                    <h5 class="card-title">Producto 1</h5>
                </div>
            </div>
        </div>

        <!-- Tarjeta 2 -->
        <div class="col-md-4 col-sm-6 mb-4">
            <div class="card product-card h-100 shadow-sm">
                <img src="{{ asset('imagenes/homeCliente/productoLogin2.jpeg') }}" class="card-img-top" alt="Producto 2">
                <div class="card-body text-center">
                    <h5 class="card-title">Producto 2</h5>
                </div>
            </div>
        </div>

        <!-- Tarjeta 3 -->
        <div class="col-md-4 col-sm-6 mb-4">
            <div class="card product-card h-100 shadow-sm">
                <img src="{{ asset('imagenes/homeCliente/productoLogin3.jpeg') }}" class="card-img-top" alt="Producto 3">
                <div class="card-body text-center">
                    <h5 class="card-title">Producto 3</h5>
                </div>
            </div>
        </div>
    </div>

    <!-- BOTÓN VER TODO -->
    <div class="text-center mt-4">
        <a href="{{ route('cliente.productos.index') }}" class="btn btn-outline-light px-4 py-2">
            VER TODO
        </a>
    </div>
</div>

<!-- TARJETAS RÁPIDAS -->
<div class="container my-5">
    <div class="row text-center">
        <div class="col-md-4 mb-3">
            <div class="card shadow option-card">
                <i class="fas fa-calendar-check fa-2x my-3 text-primary"></i>
                <h5>Mis Reservas</h5>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card shadow option-card">
                <i class="fas fa-boxes fa-2x my-3 text-success"></i>
                <h5>Productos</h5>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card shadow option-card">
                <i class="fas fa-user fa-2x my-3 text-info"></i>
                <h5>Mi Perfil</h5>
            </div>
        </div>
    </div>
</div>

@endsection

@push('js')
<script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        new Swiper('.mySwiper', {
            effect: 'coverflow',
            grabCursor: true,
            centeredSlides: true,
            slidesPerView: 'auto',
            loop: true,
            spaceBetween: 60,
            speed: 150,
            autoplay: {
                delay: 3000,
                disableOnInteraction: false,
            },
            coverflowEffect: {
                rotate: 20,
                stretch: 0,
                depth: 300,
                modifier: 1,
                slideShadows: false,
            },
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            }
        });
    });
</script>
@endpush
