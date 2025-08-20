<?php

namespace App\Providers;
use Illuminate\Support\Facades\View;
use App\Models\Reserva;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
public function boot(): void
{
    View::composer('layouts.admin', function ($view) {
        $reservasPendientes = Reserva::where('estado', 'pendiente')->count();
        $view->with('reservasPendientes', $reservasPendientes);
    });
}
}
