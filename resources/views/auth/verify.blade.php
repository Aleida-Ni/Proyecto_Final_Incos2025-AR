@extends('adminlte::auth.auth-page', ['auth_type' => 'login'])

@section('title', 'Verifica tu correo')

@section('auth_body')
    <div class="text-center">
        <h1 class="mb-4">Verifica tu dirección de correo</h1>
        <p class="mb-4">
            Antes de continuar, revisa tu correo electrónico para el enlace de verificación.<br>
            Si no lo recibiste, puedes solicitar otro.
        </p>

        @if (session('message'))
            <div class="alert alert-success">
                {{ session('message') }}
            </div>
        @endif

        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <button type="submit" class="btn btn-primary">
                Reenviar enlace de verificación
            </button>
        </form>
    </div>
@endsection
