@extends('cliente.layout')

@section('title', 'Panel Cliente')

@push('css')
<!-- Swiper CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css" />

<style>
    /* === Hero === */
    body {
        background-color: #000;
    }

    .custom-hero {
        background-image: url("{{ asset('storage/imagenes/fondocli.jpg') }}");
        background-size: cover;
        background-position: center;
        height: 300px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        padding: 30px 0;
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
        background: #007bff;
        border-radius: 8px;
        color: #fff;
        box-shadow: 0 0 10px #007bff, 0 0 20px #3399ff;
        text-decoration: none;
        transition: all .3s;
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

    /* 👇 Aumentamos el tamaño del slide activo */
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
        0% {
            opacity: .2;
            transform: translateY(0) scale(1);
        }

        50% {
            opacity: .95;
            transform: translateY(-2px) scale(1.02);
        }

        100% {
            opacity: .2;
            transform: translateY(0) scale(1);
        }
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
</style>
@endpush

@section('content')
<div class="custom-hero">
    <div class="hero-content text-center">
        <h1>Transforma tu Estilo</h1>
        <p>Reserva con los mejores barberos y explora nuestros productos exclusivos.</p>
        <a href="{{ route('cliente.barberos.index') }}" class="btn-blue">Reservar</a>
    </div>
</div>


    <div class="swiper-pagination"></div>
    <div class="swiper-button-prev"></div>
    <div class="swiper-button-next"></div>
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