@extends('cliente.layout')

@section('title', 'Barbería Elite - Inicio')

@push('css')
<!-- Swiper CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css" />

<style>
    /* === Hero Section Mejorada === */
    .custom-hero {
        background: linear-gradient(rgba(0,0,0,0.7), rgba(0,0,0,0.7)), 
                    url("{{ asset('imagenes/homeCliente/fondoCliente1.jpg') }}");
        background-size: cover;
        background-position: center;
        background-attachment: fixed;
        height: 80vh;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        text-align: center;
        position: relative;
        overflow: hidden;
    }

    .custom-hero::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(45deg, 
                    rgba(212, 175, 55, 0.1) 0%, 
                    rgba(244, 228, 168, 0.05) 50%, 
                    rgba(212, 175, 55, 0.1) 100%);
        animation: shimmer 3s ease-in-out infinite;
    }

    @keyframes shimmer {
        0%, 100% { opacity: 0.3; }
        50% { opacity: 0.7; }
    }

    .hero-content h1 {
        font-size: 4rem;
        font-weight: 700;
        color: var(--color-blanco);
        text-shadow: 2px 2px 8px rgba(0,0,0,0.8);
        margin-bottom: 1rem;
        background: linear-gradient(135deg, var(--color-blanco) 0%, var(--color-dorado) 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .hero-content p {
        font-size: 1.4rem;
        color: var(--color-beige);
        background: rgba(44, 44, 44, 0.8);
        padding: 15px 30px;
        border-radius: 10px;
        border-left: 4px solid var(--color-dorado);
        display: inline-block;
        max-width: 600px;
        margin: 0 auto;
    }

    .btn-gold {
        background: linear-gradient(135deg, var(--color-dorado) 0%, var(--color-dorado-claro) 100%);
        color: var(--color-negro) !important;
        border: none;
        border-radius: 30px;
        padding: 15px 35px;
        font-size: 1.1rem;
        font-weight: 700;
        text-decoration: none;
        box-shadow: 0 6px 20px rgba(212, 175, 55, 0.4);
        transition: all 0.4s ease;
        margin-top: 2rem;
        display: inline-flex;
        align-items: center;
        gap: 10px;
    }

    .btn-gold:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 30px rgba(212, 175, 55, 0.6);
        color: var(--color-negro) !important;
    }

    /* === Productos Destacados === */
    .products-section {
        background: linear-gradient(135deg, var(--color-beige) 0%, var(--color-blanco) 100%);
        padding: 80px 0;
    }

    .section-title {
        font-size: 2.5rem;
        font-weight: 700;
        color: var(--color-gris-oscuro);
        text-align: center;
        margin-bottom: 3rem;
        position: relative;
    }

    .section-title::after {
        content: '';
        position: absolute;
        bottom: -10px;
        left: 50%;
        transform: translateX(-50%);
        width: 100px;
        height: 3px;
        background: linear-gradient(90deg, var(--color-dorado), var(--color-dorado-claro));
        border-radius: 2px;
    }

    /* Tarjetas de productos mejoradas */
    .product-card {
        border: none;
        border-radius: 15px;
        overflow: hidden;
        transition: all 0.4s ease;
        background: var(--color-blanco);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        height: 100%;
    }

    .product-card img {
        height: 280px;
        object-fit: cover;
        transition: transform 0.4s ease;
    }

    .product-card:hover {
        transform: translateY(-12px);
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.2);
    }

    .product-card:hover img {
        transform: scale(1.08);
    }

    .product-card .card-body {
        background: linear-gradient(135deg, var(--color-blanco) 0%, var(--color-beige) 100%);
        color: var(--color-gris-oscuro);
        padding: 25px;
        text-align: center;
    }

    .product-card .card-title {
        font-weight: 600;
        color: var(--color-gris-oscuro);
        font-size: 1.1rem;
    }

    /* Botón Ver Todo mejorado */
    .btn-ver-todo {
        background: transparent;
        color: var(--color-gris-oscuro) !important;
        border: 2px solid var(--color-dorado);
        border-radius: 25px;
        padding: 12px 35px;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .btn-ver-todo:hover {
        background: linear-gradient(135deg, var(--color-dorado) 0%, var(--color-dorado-claro) 100%);
        color: var(--color-negro) !important;
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(212, 175, 55, 0.3);
    }

    /* === Swiper Gallery Mejorada === */
    .gallery-section {
        background: var(--color-negro);
        padding: 80px 0;
    }

    .gallery-title {
        color: var(--color-blanco);
        font-size: 2.5rem;
        font-weight: 700;
        text-align: center;
        margin-bottom: 3rem;
    }

    .gallery-title::after {
        content: '';
        display: block;
        width: 100px;
        height: 3px;
        background: linear-gradient(90deg, var(--color-dorado), var(--color-dorado-claro));
        margin: 10px auto 0;
        border-radius: 2px;
    }

    :root {
        --slide-width: 500px;
        --slide-height: 350px;
    }

    .swiper {
        width: 100%;
        max-width: 1400px;
        margin: 0 auto;
        padding: 0 60px;
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
        border-radius: 20px;
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.8);
        transition: all 0.45s cubic-bezier(.22, .9, .33, 1);
    }

    /* Efecto zoom en el slide activo */
    .swiper-slide-active .slide-img {
        transform: scale(1.15);
        box-shadow: 0 20px 50px rgba(212, 175, 55, 0.4);
    }

    .slide-caption {
        position: absolute;
        left: 25px;
        bottom: 25px;
        color: var(--color-blanco);
        font-weight: 700;
        text-shadow: 0 3px 15px rgba(0, 0, 0, 0.8);
        font-size: 1.1rem;
    }

    /* Controles del swiper */
    .swiper-button-next,
    .swiper-button-prev {
        color: var(--color-dorado);
        width: 55px;
        height: 55px;
        border-radius: 50%;
        background: rgba(44, 44, 44, 0.8);
        box-shadow: 0 0 20px rgba(212, 175, 55, 0.3);
        transition: all 0.3s ease;
    }

    .swiper-button-next:hover,
    .swiper-button-prev:hover {
        background: var(--color-dorado);
        color: var(--color-negro);
    }

    /* Bullets del swiper */
    .swiper-pagination-bullet {
        background: rgba(212, 175, 55, 0.6);
        opacity: 1;
        width: 12px;
        height: 12px;
        transition: all 0.3s ease;
    }

    .swiper-pagination-bullet-active {
        background: var(--color-dorado);
        transform: scale(1.2);
        box-shadow: 0 0 15px var(--color-dorado);
    }

    /* Efectos de brillo en slides */
    .sparkle-overlay {
        position: absolute;
        inset: 0;
        border-radius: 20px;
        pointer-events: none;
        background-image:
            radial-gradient(3px 3px at 15% 25%, rgba(212, 175, 55, .8), rgba(212, 175, 55, 0)),
            radial-gradient(2.5px 2.5px at 65% 60%, rgba(244, 228, 168, .7), rgba(244, 228, 168, 0)),
            radial-gradient(2px 2px at 35% 80%, rgba(212, 175, 55, .6), rgba(212, 175, 55, 0)),
            radial-gradient(1.8px 1.8px at 80% 20%, rgba(255, 255, 255, .9), rgba(255, 255, 255, 0));
        background-repeat: no-repeat;
        opacity: .6;
        animation: twinkle-gold 4.5s ease-in-out infinite;
    }

    @keyframes twinkle-gold {
        0% { opacity: .3; transform: translateY(0) scale(1); }
        50% { opacity: .9; transform: translateY(-3px) scale(1.03); }
        100% { opacity: .3; transform: translateY(0) scale(1); }
    }

    /* Responsive */
    @media (max-width: 1200px) {
        :root {
            --slide-width: 400px;
            --slide-height: 280px;
        }
        
        .hero-content h1 {
            font-size: 3rem;
        }
    }

    @media (max-width: 768px) {
        :root {
            --slide-width: 300px;
            --slide-height: 200px;
        }
        
        .hero-content h1 {
            font-size: 2.5rem;
        }
        
        .hero-content p {
            font-size: 1.1rem;
            padding: 12px 20px;
        }
        
        .custom-hero {
            height: 60vh;
        }
        
        .swiper {
            padding: 0 30px;
        }
    }

    @media (max-width: 576px) {
        :root {
            --slide-width: 250px;
            --slide-height: 180px;
        }
        
        .hero-content h1 {
            font-size: 2rem;
        }
        
        .section-title {
            font-size: 2rem;
        }
    }
</style>
@endpush

@section('content')

<!-- HERO SECTION -->
<div class="custom-hero">
    <div class="hero-content">
        <h1>BARBERÍA ELITE</h1>
        <p>Experiencia premium en cortes y estilos. Reserva con nuestros expertos barberos y descubre productos exclusivos.</p>
        <a href="{{ route('cliente.barberos.index') }}" class="btn-gold">
            <i class="fas fa-calendar-plus"></i> RESERVAR CITA
        </a>
    </div>
    <!-- Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const swiper = new Swiper('.mySwiper', {
                loop: true,
                centeredSlides: true,
                slidesPerView: 'auto',
                spaceBetween: 30,
                pagination: {
                    el: '.swiper-pagination',
                    clickable: true,
                },
                navigation: {
                    nextEl: '.swiper-button-next',
                    prevEl: '.swiper-button-prev',
                },
                breakpoints: {
                    576: { slidesPerView: 1 },
                    768: { slidesPerView: 1.2 },
                    992: { slidesPerView: 2 },
                    1200: { slidesPerView: 3 }
                }
            });
        });
    </script>
</div>

<!-- GALERÍA DE TRABAJOS -->
<div class="gallery-section">
    <h2 class="gallery-title">Nuestros Trabajos</h2>
    
    <!-- Swiper -->
    <div class="swiper mySwiper">
        <div class="swiper-wrapper">
            {{-- Carousel generado automáticamente desde public/imagenes/cliente --}}
            @php
                $clienteImgs = ['DSC05513.jpg','DSC05533.jpg','DSC05550.jpg','_DSC5342.jpg'];
            @endphp
            @foreach($clienteImgs as $idx => $img)
            <div class="swiper-slide">
                <img src="{{ asset('imagenes/cliente/' . $img) }}" class="slide-img" alt="Galería {{ $idx + 1 }}">
                <div class="sparkle-overlay"></div>
                <div class="slide-caption">Galería {{ $idx + 1 }}</div>
            </div>
            @endforeach
        </div>
        <div class="swiper-pagination"></div>
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
    </div>
</div>

<!-- PRODUCTOS DESTACADOS -->
<div class="products-section">
    <div class="container">
        <h2 class="section-title">Productos Destacados</h2>

        <div class="row justify-content-center">
            <!-- Producto 1 -->
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card product-card h-100">
                    <img src="{{ asset('imagenes/homeCliente/productoLogin1.jpeg') }}" class="card-img-top" alt="Aceite para Barba">
                    <div class="card-body">
                        <h5 class="card-title">Aceite Premium para Barba</h5>
                        <p class="card-text text-muted">Hidratación y brillo natural</p>
                    </div>
                </div>
            </div>

            <!-- Producto 2 -->
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card product-card h-100">
                    <img src="{{ asset('imagenes/homeCliente/productoLogin2.jpeg') }}" class="card-img-top" alt="Cera Modeladora">
                    <div class="card-body">
                        <h5 class="card-title">Cera Modeladora Elite</h5>
                        <p class="card-text text-muted">Fijación máxima y acabado mate</p>
                    </div>
                </div>
            </div>

            <!-- Producto 3 -->
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card product-card h-100">
                    <img src="{{ asset('imagenes/homeCliente/productoLogin3.jpeg') }}" class="card-img-top" alt="Kit de Barbería">
                    <div class="card-body">
                        <h5 class="card-title">Kit Profesional Barber</h5>
                        <p class="card-text text-muted">Todo lo necesario para el cuidado</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- BOTÓN VER TODO -->
        <div class="text-center mt-5">
            <a href="{{ route('cliente.productos.index') }}" class="btn-ver-todo">
                <i class="fas fa-store"></i> VER TODOS LOS PRODUCTOS
            </a>
        </div>
        <!-- Add Pagination -->
        <div class="swiper-pagination"></div>
        <!-- Add Navigation -->
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
    </div>
</div>

@endsection

@push('js')
<script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        // Inicializar Swiper
        new Swiper('.mySwiper', {
            effect: 'coverflow',
            grabCursor: true,
            centeredSlides: true,
            slidesPerView: 'auto',
            loop: true,
            spaceBetween: 40,
            speed: 800,
            autoplay: {
                delay: 4000,
                disableOnInteraction: false,
            },
            coverflowEffect: {
                rotate: 15,
                stretch: 0,
                depth: 200,
                modifier: 1.5,
                slideShadows: false,
            },
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
                dynamicBullets: true,
            },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            breakpoints: {
                320: {
                    spaceBetween: 20,
                    coverflowEffect: {
                        rotate: 10,
                        depth: 100,
                    }
                },
                768: {
                    spaceBetween: 30,
                    coverflowEffect: {
                        rotate: 15,
                        depth: 150,
                    }
                },
                1200: {
                    spaceBetween: 40,
                    coverflowEffect: {
                        rotate: 15,
                        depth: 200,
                    }
                }
            }
        });

        // Efecto de aparición suave al hacer scroll
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, observerOptions);

        // Observar elementos para animación
        document.querySelectorAll('.product-card, .section-title, .btn-ver-todo').forEach(el => {
            el.style.opacity = '0';
            el.style.transform = 'translateY(30px)';
            el.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
            observer.observe(el);
        });
    });
</script>
@endpush