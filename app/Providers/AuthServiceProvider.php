<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        //
    ];

    public function boot(): void
    {
        $this->registerPolicies();

        // Roles generales
        Gate::define('is-admin', fn($user) => $user->rol === 'admin');
        Gate::define('is-cliente', fn($user) => $user->rol === 'cliente');
        Gate::define('is-empleado', fn($user) => $user->rol === 'empleado');

        // Gates para el menú
        Gate::define('menu-admin', fn($user) => $user->rol === 'admin');
        Gate::define('menu-empleado', fn($user) => $user->rol === 'empleado');
    }
}
