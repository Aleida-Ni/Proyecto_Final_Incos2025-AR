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
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    });

Route::middleware(['auth', 'role:empleado'])->prefix('empleado')->name('empleado.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
});



// Panel empleado
Route::middleware(['auth', 'role:empleado'])
    ->prefix('empleado')
    ->name('empleado.')
    ->group(function () {

        // Dashboard del empleado
        Route::get('/dashboard', [App\Http\Controllers\Empleado\DashboardController::class, 'index'])
            ->name('dashboard');

        // Barberos (mismos controladores que admin)
        Route::resource('barberos', App\Http\Controllers\Admin\BarberoController::class);

        // Productos
        Route::resource('productos', App\Http\Controllers\Admin\ProductoController::class);

        // Reservas
        Route::resource('reservas', App\Http\Controllers\Admin\ReservaController::class);
    });



/* =======================
   PANEL ADMIN
========================== */

// Ruta principal del panel admin
Route::middleware(['auth', 'role:admin|empleado'])->prefix('admin')->name('admin.')->group(function () {

    // Dashboard
    Route::get('/', function () {
        $pendientes = \App\Models\Reserva::where('estado', 'pendiente')->count();
        return view('admin.dashboard', compact('pendientes'));
    })->name('dashboard');

    // Productos
    Route::resource('productos', AdminProductoController::class);

    // Barberos
    Route::resource('barberos', AdminBarberoController::class);

    // Reservas
    Route::get('reservas', [AdminReservaController::class, 'index'])->name('reservas.index');

    Route::prefix('admin/config')->group(function () {
        Route::resource('empleados', App\Http\Controllers\Admin\EmpleadoController::class);
    // Configuración
    Route::view('settings', 'admin.settings')->name('settings');



});




/* =======================
   PANEL CLIENTE
========================== */
Route::middleware(['auth', 'can:is-cliente'])->group(function () {

    // Dashboard del cliente con lista de barberos
    Route::get('/home', function () {
        $barberos = Barbero::all();
        return view('cliente.home', compact('barberos'));
    })->name('cliente.home');

    Route::middleware(['auth'])->prefix('cliente')->name('cliente.')->group(function () {
        Route::get('/inicio', [\App\Http\Controllers\Cliente\HomeController::class, 'inicio'])->name('inicio');
    });

    // Acceso a funcionalidades del cliente
    Route::prefix('cliente')->name('cliente.')->group(function () {
        Route::get('/inicio', [\App\Http\Controllers\Cliente\HomeController::class, 'inicio'])->name('inicio');

    });
    Route::middleware(['auth', 'can:is-cliente'])->prefix('cliente')->name('cliente.')->group(function () {
    Route::get('/barberos', [ClienteBarberoController::class, 'index'])->name('barberos.index');


});
Route::middleware(['auth', 'can:is-cliente'])->prefix('cliente')->name('cliente.')->group(function () {
    Route::get('/barberos', [App\Http\Controllers\Cliente\BarberoController::class, 'index'])->name('barberos.index');
    Route::get('/reservar/{barbero}', [ClienteReservaController::class, 'create'])->name('reservar');
    Route::post('/reservar', [ClienteReservaController::class, 'store'])->name('reservar.store');
    Route::get('/reservas', [ClienteReservaController::class, 'misReservas'])->name('reservas');
});

Route::middleware(['auth', 'role:cliente'])->prefix('cliente')->name('cliente.')->group(function () {
    Route::post('/ventas', [App\Http\Controllers\Cliente\VentaController::class, 'store'])->name('ventas.store');
    Route::get('/ventas/{venta}', [App\Http\Controllers\Cliente\VentaController::class, 'show'])->name('ventas.show');
});

Route::prefix('venta')->name('venta.')->group(function () {
    Route::post('/agregar', [VentaController::class, 'agregar'])->name('agregar');
    Route::get('/contenido', [VentaController::class, 'contenido'])->name('contenido'); // retorna JSON para badge/modal
    Route::post('/actualizar', [VentaController::class, 'actualizar'])->name('actualizar');
    Route::post('/quitar', [VentaController::class, 'quitar'])->name('quitar');
    Route::get('/', [VentaController::class, 'mostrar'])->name('mostrar'); // vista completa opcional
});

Route::prefix('cliente')->name('cliente.')->group(function () {
    Route::get('/ventas', [VentaController::class, 'index'])->name('ventas.index');
    Route::post('/ventas/agregar/{producto}', [VentaController::class, 'agregar'])->name('ventas.agregar');
    Route::post('/ventas/eliminar/{producto}', [VentaController::class, 'eliminar'])->name('ventas.eliminar');
});

Route::post('/venta/confirmar', [VentaController::class, 'confirmarCompra'])->name('venta.confirmar');

Route::post('/cliente/ventas/confirmar', [VentaController::class, 'confirmarCompra'])
    ->middleware(['auth', 'can:is-cliente'])
    ->name('cliente.ventas.confirmar');

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


});

