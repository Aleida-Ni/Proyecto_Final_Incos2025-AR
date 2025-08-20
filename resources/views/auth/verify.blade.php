@extends('adminlte::page')

@section('title', 'Verifica tu correo')

@section('content')
<div class="container text-center mt-5">
    <h1 class="mb-4">Verifica tu dirección de correo</h1>
    <p>
        Antes de continuar, revisa tu correo electrónico para el enlace de verificación.<br>
        Si no lo recibiste, puedes solicitar otro.
    </p>

    @if (session('message'))
        <div class="alert alert-success mt-3">
            {{ session('message') }}
        </div>
    @endif

    <form method="POST" action="{{ route('verification.send') }}">
        @csrf
        <button type="submit" class="btn btn-primary mt-3">
            Reenviar enlace de verificación
        </button>
    </form>
</div>
@endsection
