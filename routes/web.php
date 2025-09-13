<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Models\Barbero;
use App\Models\Reserva;

// Controladores Cliente
use App\Http\Controllers\Cliente\HomeController as ClienteHomeController;
use App\Http\Controllers\Cliente\BarberoController as ClienteBarberoController;
use App\Http\Controllers\Cliente\ProductoController as ClienteProductoController;
use App\Http\Controllers\Cliente\ReservaController as ClienteReservaController;
use App\Http\Controllers\Cliente\VentaController;

// Controladores Admin
use App\Http\Controllers\Admin\BarberoController as AdminBarberoController;
use App\Http\Controllers\Admin\ProductoController as AdminProductoController;
use App\Http\Controllers\Admin\ReservaController as AdminReservaController;
use App\Http\Controllers\Admin\EmpleadoController;


use Illuminate\Foundation\Auth\EmailVerificationRequest;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\Empleado\DashboardController;

// =============================
// RUTAS DE AUTENTICACIÓN
// =============================
Auth::routes(['verify' => true]);

// Página de bienvenida
Route::get('/', function () {
    return view('welcome');
});

// =============================
// VERIFICACIÓN DE CORREO
// =============================
Route::get('/email/verify', [VerificationController::class, 'notice'])
    ->middleware('auth')
    ->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $user = $request->user();

    if (!$user->correo_verificado_en) {
        $user->correo_verificado_en = now();
        $user->estado = 1;
        $user->save();
    }

    if ($user->rol === 'admin') {
        return redirect()->route('admin');
    } elseif ($user->rol === 'empleado') {
        return redirect()->route('empleado.dashboard');
    } else {
        return redirect()->route('cliente.home')->with('status', '¡Correo verificado correctamente!');
    }
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', [VerificationController::class, 'send'])
    ->middleware(['auth', 'throttle:6,1'])
    ->name('verification.send');

// =============================
// PANEL ADMIN
// =============================
Route::get('/admin', [DashboardController::class, 'index'])
    ->middleware(['auth', 'estado', 'role:admin'])
    ->name('admin');

Route::middleware(['auth', 'role:admin|empleado'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/', function () {
            $pendientes = \App\Models\Reserva::where('estado', 'pendiente')->count();
            return view('admin.dashboard', compact('pendientes'));
        })->name('dashboard');

        Route::resource('productos', AdminProductoController::class);
        Route::resource('barberos', AdminBarberoController::class);
        Route::get('reservas', [AdminReservaController::class, 'index'])->name('reservas.index');

        Route::prefix('config')->group(function () {
            Route::resource('empleados', EmpleadoController::class);
            Route::view('settings', 'admin.settings')->name('settings');
        });

        Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin'])->group(function () {
            Route::resource('empleados', EmpleadoController::class);
        });
    });

// =============================
// PANEL EMPLEADO
// =============================


Route::middleware(['auth', 'role:empleado'])
    ->prefix('empleado')
    ->name('empleado.')
    ->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::resource('barberos', AdminBarberoController::class);
        Route::resource('productos', AdminProductoController::class);
        Route::resource('reservas', AdminReservaController::class);
    });



// =============================
// PANEL CLIENTE
// =============================
Route::middleware(['auth', 'verified', 'estado', 'can:is-cliente'])
    ->group(function () {

        // Dashboard directo con lista de barberos
        Route::get('/home', function () {
            $barberos = Barbero::all();
            return view('cliente.home', compact('barberos'));
        })->name('cliente.home');

        Route::middleware(['auth'])->prefix('cliente')->name('cliente.')->group(function () {
            Route::get('/inicio', [ClienteHomeController::class, 'inicio'])->name('inicio');
        });

        // Acceso a funcionalidades del cliente
        Route::prefix('cliente')->name('cliente.')->group(function () {
            Route::get('/inicio', [ClienteHomeController::class, 'inicio'])->name('inicio');
        });


        Route::middleware(['auth', 'can:is-cliente'])->prefix('cliente')->name('cliente.')->group(function () {
            Route::get('/barberos', [App\Http\Controllers\Cliente\BarberoController::class, 'index'])->name('barberos.index');
            Route::get('/reservar/{barbero}', [ClienteReservaController::class, 'create'])->name('reservar');
            Route::post('/reservar', [ClienteReservaController::class, 'store'])->name('reservar.store');
            Route::get('/reservas', [ClienteReservaController::class, 'misReservas'])->name('reservas');
        });

        Route::prefix('cliente')->name('cliente.')->middleware(['auth', 'verified', 'estado', 'can:is-cliente'])->group(function () {

            Route::get('/productos', [\App\Http\Controllers\Cliente\ProductoController::class, 'index'])->name('productos.index');

            // Rutas del carrito
            Route::post('/ventas/agregar/{id}', [VentaController::class, 'agregar'])->name('ventas.agregar');
            Route::post('/ventas/vaciar', [VentaController::class, 'vaciar'])->name('ventas.vaciar');
            Route::get('/ventas/carrito', [VentaController::class, 'modalCarrito'])->name('ventas.carrito');
            Route::post('/ventas/confirmar', [VentaController::class, 'confirmarCompra'])->name('ventas.confirmar');
            Route::post('/ventas/eliminar/{id}', [VentaController::class, 'eliminar'])->name('ventas.eliminar');
        });
        // Carrito
        Route::post('/carrito/{id}/aumentar', [App\Http\Controllers\Cliente\VentaController::class, 'aumentar'])
            ->name('cliente.ventas.aumentar');
        Route::post('/carrito/{id}/disminuir', [App\Http\Controllers\Cliente\VentaController::class, 'disminuir'])
            ->name('cliente.ventas.disminuir');



        // Productos
        Route::get('/productos', [ClienteProductoController::class, 'index'])->name('productos.index');
        Route::get('/cliente/productos', [\App\Http\Controllers\Cliente\ProductoController::class, 'index'])
            ->name('cliente.productos.index');
    });
