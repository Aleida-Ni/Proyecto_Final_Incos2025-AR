@extends('adminlte::page')

@section('title', 'Bienvenido')

@section('content_header')
    <h1 class="text-center text-white font-weight-bold title-shadow">Bienvenido al Panel</h1>
@endsection

@section('content')
    <div class="welcome-container text-center">
        <img src="{{ asset('storage/imagenes/logoStars.png') }}" alt="Logo" class="welcome-logo mb-4">
    </div>
@endsection

@section('css')
    <style>
        /* Fondo fijo en azul degradado */
        body {
            background: linear-gradient(to bottom, #003366, #0059b3, #3399ff);
        }

        /* Logo con sombra negra */
        .welcome-logo {
            max-width: 200px;
            filter: drop-shadow(0px 0px 18px rgba(10, 10, 10, 0.8));
        }

        /* Mejorar visibilidad del título */
        .title-shadow {
            text-shadow: 2px 2px 6px rgba(0,0,0,0.6);
        }

        /* Contenedor de bienvenida */
        .welcome-container {
            margin-top: 100px;
        }

        /* Sidebar degradado */
        .main-sidebar {
            background: linear-gradient(to bottom, #003366, #0059b3, #3399ff) !important;
        }

        .main-sidebar .nav-link, 
        .main-sidebar .brand-link {
            color: white !important;
        }

        .main-sidebar .nav-link.active {
            background: rgba(255, 255, 255, 0.2) !important;
            border-radius: 10px;
        }
    </style>
@endsection
