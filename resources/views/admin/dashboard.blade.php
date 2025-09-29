@extends('adminlte::page')

@section('content')

    <div class="hero-section">
        <div class="container py-5">
            <h1 class="display-4 fw-bold">Transforma tu estilo</h1>
            <p class="lead">Descubre barberos expertos y productos de alta calidad</p>
        </div>
    </div>

    <div class="white-section py-5">
        <div class="container">
        </div>
    </div>

@endsection

@push('css')
<style>
    .hero-section {
        background-color: #f8f9fa; 
        padding-top: 80px;
        padding-bottom: 100px;
        color: #212529; 
    }

    .white-section {
        background-color: #fff;
    }
</style>
@endpush
