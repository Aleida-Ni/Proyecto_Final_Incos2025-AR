@extends('adminlte::page')

@section('title', 'Bienvenido')

@section('content_header')
    <h1 class="text-center text-white font-weight-bold title-shadow">Bienvenido al Panel</h1>
@endsection

@section('content')

@endsection

@section('css')
    <style>
        /* Fondo fijo en azul degradado */
/* Fondo del panel principal */
body {
    background: linear-gradient(to bottom, #2f2f2f, #4a4a4a); /* degradado plomo */
}

/* Sidebar degradado plomo oscuro -> claro */
.main-sidebar {
    position: relative;
    background: linear-gradient(to bottom, #3a3a3a, #6b6b6b) !important;
    overflow: hidden; /* Para que los elementos decorativos no sobresalgan */
}
.main-sidebar::before {
    content: '';
    position: absolute;
    top: -50px;
    left: -50px;
    width: 200px;
    height: 200px;
    background: rgba(255, 255, 255, 0.05);
    border-radius: 50%;
    z-index: 0;
}
.main-sidebar::after {
    content: '';
    position: absolute;
    bottom: -40px;
    right: -60px;
    width: 150px;
    height: 150px;
    background: rgba(255, 255, 255, 0.08);
    border-radius: 50%;
    z-index: 0;
}

/* Asegurar que links estén sobre los círculos */
.main-sidebar .nav-link,
.main-sidebar .brand-link {
    position: relative;
    z-index: 1;
}

/* Sidebar links activos */
.main-sidebar .nav-link.active {
    background: rgba(255, 255, 255, 0.15) !important;
    border-radius: 10px;
    color: #ffffff !important;
}


/* Sidebar links hover */
.main-sidebar .nav-link:hover {
    background: rgba(255, 255, 255, 0.1) !important;
    color: #ffffff !important;
}

/* Topnav con círculos */
.navbar {
    position: relative;
    background: linear-gradient(to right, #3a3a3a, #6b6b6b) !important;
    overflow: hidden;
}

/* Asegurar que links del navbar estén sobre los círculos */
.navbar .nav-link,
.navbar .navbar-brand {
    position: relative;
    z-index: 1;
}

/* Links de topnav hover */
.navbar .nav-link:hover {
    color: #ffffff !important;
}
.navbar::before {
    content: '';
    position: absolute;
    top: 10px;
    right: 20px;
    width: 100px;
    height: 100px;
    background: rgba(255, 255, 255, 0.05);
    border-radius: 50%;
    z-index: 0;
}
.navbar::after {
    content: '';
    position: absolute;
    bottom: 5px;
    left: 30px;
    width: 60px;
    height: 60px;
    background: rgba(255, 255, 255, 0.07);
    border-radius: 50%;
    z-index: 0;
}
/* Título del panel (content_header) */
.content-header h1 {
    color: #e0e0e0;
    text-shadow: 1px 1px 4px rgba(0, 0, 0, 0.7);
}

/* Botones principales */
.btn-primary {
    background: linear-gradient(to right, #555555, #888888);
    border: none;
    color: #ffffff;
    font-weight: bold;
    transition: 0.3s ease;
}

.btn-primary:hover {
    background: linear-gradient(to right, #777777, #aaaaaa);
}

/* Tarjetas / cajas */
.card {
    background: rgba(60, 60, 60, 0.85);
    color: #e0e0e0;
    border-radius: 10px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.5);
}

/* Inputs */
.form-control, .input-group-text {
    background: rgba(100, 100, 100, 0.3);
    color: #ffffff;
    border: none;
}

/* Títulos dentro de tarjetas */
.card h3, .card h4 {
    color: #ffffff;
    text-shadow: 1px 1px 3px rgba(0,0,0,0.6);
}

/* Links comunes */
a {
    color: #c5c5c5;
}

a:hover {
    color: #ffffff;
}

/* Footer si existiera */
.main-footer {
    background: linear-gradient(to right, #3a3a3a, #6b6b6b);
    color: #e0e0e0;
}

/* Ajuste del scroll del sidebar si quieres */
.sidebar-dark-primary .nav-sidebar>.nav-item>.nav-link {
    border-left: none;
}

    </style>
@endsection
