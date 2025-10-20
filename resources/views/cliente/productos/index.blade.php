@extends('cliente.layout')

@section('title', 'Productos - Barbería Elite')

@section('content')
<div class="container my-5">

    <!-- Encabezado elegante -->
    <div class="text-center mb-5">
        <h1 class="fw-bold text-gris-oscuro mb-3">Nuestros Productos Premium</h1>
        <p class="text-gris-medio fs-5">Descubre nuestra selección exclusiva para el cuidado masculino</p>
    </div>

    {{-- Filtro de Categorías Elegante --}}
    <div class="text-center mb-5">
        <div class="dropdown-categorias d-inline-block position-relative">
            <button class="btn btn-categorias fw-semibold dropdown-toggle" type="button">
                <i class="fas fa-filter me-2"></i>Filtrar por Categoría
            </button>
            <div class="categorias-menu shadow-lg">
                <a href="{{ route('cliente.productos.index') }}" class="categoria-item">
                    <i class="fas fa-th-large me-2"></i>Todas las Categorías
                </a>
                <div class="dropdown-divider"></div>
                <a href="{{ route('cliente.productos.index', ['categoria' => 'CERAS Y GELES']) }}" class="categoria-item">
                    <i class="fas fa-paint-brush me-2"></i>Ceras y Geles
                </a>
                <a href="{{ route('cliente.productos.index', ['categoria' => 'CUIDADOS DE BARBA']) }}" class="categoria-item">
                    <i class="fas fa-leaf me-2"></i>Cuidados de Barba
                </a>
                <a href="{{ route('cliente.productos.index', ['categoria' => 'CAPAS PERSONALIZADAS']) }}" class="categoria-item">
                    <i class="fas fa-tshirt me-2"></i>Capas Personalizadas
                </a>
            </div>
        </div>
    </div>

    @php
    $productosPorCategoria = $productos->groupBy(function($p){
        return optional($p->categoria)->nombre ?? 'Sin categoría';
    });
    @endphp

    @foreach($productosPorCategoria as $categoriaNombre => $items)
        <!-- Encabezado de categoría -->
        <div class="categoria-header mb-4">
            <h3 class="categoria-titulo">
                <i class="fas fa-tag me-2"></i>{{ strtoupper($categoriaNombre) }}
            </h3>
            <div class="categoria-linea"></div>
        </div>

        <!-- Grid de productos -->
        <div class="row g-4 mb-5">
            @foreach($items as $producto)
                <div class="col-xl-3 col-lg-4 col-md-6 mb-4">
                    <div class="card producto-card border-0 shadow-sm h-100">
                        @if($producto->imagen)
                            <div class="producto-img-container">
                                <img src="{{ asset('storage/' . $producto->imagen) }}" 
                                     alt="Imagen de {{ $producto->nombre }}" 
                                     class="producto-img">
                                <div class="producto-overlay">
                                    <div class="overlay-content">
                                        <span class="price-tag">Bs. {{ number_format($producto->precio, 2) }}</span>
                                        @if($producto->stock > 0)
                                            <span class="stock-badge in-stock">
                                                <i class="fas fa-check me-1"></i>Disponible
                                            </span>
                                        @else
                                            <span class="stock-badge out-of-stock">
                                                <i class="fas fa-times me-1"></i>Agotado
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="no-img-placeholder">
                                <i class="fas fa-box-open fa-3x text-beige-oscuro"></i>
                                <p class="mt-2 mb-0 text-gris-medio">Sin Imagen</p>
                            </div>
                        @endif

                        <div class="card-body text-center p-4">
                            <h5 class="producto-nombre fw-semibold text-gris-oscuro mb-2">{{ $producto->nombre }}</h5>
                            <p class="producto-categoria text-gris-medio small mb-3">
                                <i class="fas fa-tag me-1"></i>{{ $categoriaNombre }}
                            </p>
                            @if($producto->stock > 0)
                                <div class="producto-stock text-success small">
                                    <i class="fas fa-box me-1"></i>{{ $producto->stock }} en stock
                                </div>
                            @else
                                <div class="producto-stock text-danger small">
                                    <i class="fas fa-exclamation-triangle me-1"></i>Producto agotado
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endforeach

    <!-- Mensaje cuando no hay productos -->
    @if($productos->isEmpty())
        <div class="text-center py-5">
            <div class="empty-state">
                <i class="fas fa-box-open fa-4x text-beige-oscuro mb-4"></i>
                <h3 class="text-gris-medio mb-3">No hay productos disponibles</h3>
                <p class="text-gris-medio">Pronto tendremos nuevos productos en stock.</p>
            </div>
        </div>
    @endif

</div>

<style>
    /* Variables CSS */
    :root {
        --color-blanco: #FFFFFF;
        --color-negro: #000000;
        --color-dorado: #D4AF37;
        --color-dorado-claro: #F4E4A8;
        --color-beige: #F5F5DC;
        --color-beige-oscuro: #E8E4D5;
        --color-gris-oscuro: #2C2C2C;
        --color-gris-medio: #4A4A4A;
    }

    body {
        background: linear-gradient(135deg, var(--color-beige) 0%, var(--color-blanco) 100%) !important;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
.container.my-5 {
    margin-top: 120px !important;
    padding-top: 20px;
}

.text-center.mb-5 {
    padding-top: 30px;
}
@media (max-width: 768px) {
    .content-wrapper {
        margin-top: 180px !important;
    }
    
    .main-header.navbar.scrolled ~ .content-wrapper {
        margin-top: 150px !important;
    }
    
    h1 {
        font-size: 2.2rem;
        margin-top: 15px;
    }
}
    /* Encabezado principal */
    h1 {
        background: linear-gradient(135deg, var(--color-gris-oscuro) 0%, var(--color-dorado) 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        font-size: 2.8rem;
        font-weight: 700;
        letter-spacing: -0.5px;
    }

    /* Dropdown de categorías mejorado */
    .btn-categorias {
        background: linear-gradient(135deg, var(--color-blanco) 0%, var(--color-beige) 100%);
        color: var(--color-gris-oscuro) !important;
        border: 2px solid var(--color-dorado);
        border-radius: 25px;
        padding: 12px 25px;
        font-weight: 600;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(212, 175, 55, 0.2);
    }

    .btn-categorias:hover {
        background: linear-gradient(135deg, var(--color-dorado) 0%, var(--color-dorado-claro) 100%);
        color: var(--color-negro) !important;
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(212, 175, 55, 0.3);
    }

    .categorias-menu {
        display: none;
        position: absolute;
        top: 110%;
        left: 50%;
        transform: translateX(-50%);
        background: linear-gradient(135deg, var(--color-blanco) 0%, var(--color-beige) 100%);
        border-radius: 15px;
        padding: 15px 0;
        min-width: 280px;
        z-index: 1000;
        border: 2px solid var(--color-dorado);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
    }

    .dropdown-categorias:hover .categorias-menu {
        display: block;
        animation: fadeInUp 0.3s ease;
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateX(-50%) translateY(10px);
        }
        to {
            opacity: 1;
            transform: translateX(-50%) translateY(0);
        }
    }

    .categoria-item {
        display: flex;
        align-items: center;
        padding: 12px 20px;
        color: var(--color-gris-oscuro);
        font-weight: 500;
        text-decoration: none;
        transition: all 0.3s ease;
        border-left: 3px solid transparent;
    }

    .categoria-item:hover {
        background: linear-gradient(135deg, var(--color-dorado-claro) 0%, var(--color-beige) 100%);
        color: var(--color-negro);
        border-left: 3px solid var(--color-dorado);
        transform: translateX(5px);
    }

    .dropdown-divider {
        height: 1px;
        background: linear-gradient(90deg, transparent, var(--color-dorado), transparent);
        margin: 8px 20px;
    }

    /* Encabezado de categoría */
    .categoria-header {
        position: relative;
        margin-bottom: 2rem;
    }

    .categoria-titulo {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--color-gris-oscuro);
        margin-bottom: 0.5rem;
        padding-left: 1rem;
        border-left: 4px solid var(--color-dorado);
    }

    .categoria-linea {
        height: 2px;
        background: linear-gradient(90deg, var(--color-dorado), transparent);
        margin-top: 0.5rem;
    }

    /* Tarjetas de producto mejoradas */
    .producto-card {
        border-radius: 20px;
        transition: all 0.4s ease;
        overflow: hidden;
        background: var(--color-blanco);
        border: 1px solid var(--color-beige-oscuro);
    }

    .producto-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
        border-color: var(--color-dorado);
    }

    .producto-img-container {
        position: relative;
        overflow: hidden;
        height: 250px;
    }

    .producto-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.4s ease;
    }

    .producto-card:hover .producto-img {
        transform: scale(1.1);
    }

    /* Overlay elegante */
    .producto-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(to bottom, 
                    rgba(0, 0, 0, 0) 0%, 
                    rgba(0, 0, 0, 0.7) 100%);
        display: flex;
        align-items: flex-end;
        opacity: 0;
        transition: opacity 0.4s ease;
        padding: 20px;
    }

    .producto-card:hover .producto-overlay {
        opacity: 1;
    }

    .overlay-content {
        width: 100%;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .price-tag {
        background: linear-gradient(135deg, var(--color-dorado) 0%, var(--color-dorado-claro) 100%);
        color: var(--color-negro);
        font-weight: 700;
        border-radius: 20px;
        padding: 8px 16px;
        font-size: 1rem;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
    }

    .stock-badge {
        padding: 6px 12px;
        border-radius: 15px;
        font-size: 0.8rem;
        font-weight: 600;
    }

    .in-stock {
        background: rgba(40, 167, 69, 0.9);
        color: var(--color-blanco);
    }

    .out-of-stock {
        background: rgba(220, 53, 69, 0.9);
        color: var(--color-blanco);
    }

    /* Placeholder para imágenes faltantes */
    .no-img-placeholder {
        height: 250px;
        background: linear-gradient(135deg, var(--color-beige) 0%, var(--color-beige-oscuro) 100%);
        color: var(--color-gris-medio);
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        font-weight: 500;
    }

    /* Información del producto */
    .producto-nombre {
        font-size: 1.1rem;
        line-height: 1.4;
        min-height: 3rem;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .producto-categoria {
        color: var(--color-gris-medio);
        font-weight: 500;
    }

    .producto-stock {
        font-weight: 600;
    }

    /* Estado vacío */
    .empty-state {
        padding: 4rem 2rem;
    }

    /* Responsive */
    @media (max-width: 768px) {
        h1 {
            font-size: 2.2rem;
        }
        
        .categorias-menu {
            min-width: 250px;
            left: 50%;
            transform: translateX(-50%);
        }
        
        .producto-img-container {
            height: 200px;
        }
        
        .producto-nombre {
            font-size: 1rem;
        }
    }

    @media (max-width: 576px) {
        .container {
            padding: 0 15px;
        }
        
        h1 {
            font-size: 1.8rem;
        }
        
        .btn-categorias {
            padding: 10px 20px;
            font-size: 0.9rem;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Efecto de aparición suave para las tarjetas
        const productCards = document.querySelectorAll('.producto-card');
        
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        });

        productCards.forEach(card => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(30px)';
            card.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
            observer.observe(card);
        });

        // Cerrar dropdown al hacer clic fuera
        document.addEventListener('click', function(e) {
            const dropdown = document.querySelector('.dropdown-categorias');
            if (!dropdown.contains(e.target)) {
                const menu = dropdown.querySelector('.categorias-menu');
                menu.style.display = 'none';
            }
        });
    });
</script>
@endsection