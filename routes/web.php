<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;

// Models / Controllers
use App\Models\Barbero;
use App\Http\Controllers\Cliente\HomeController as ClienteHomeController;
use App\Http\Controllers\Cliente\BarberoController as ClienteBarberoController;
use App\Http\Controllers\Cliente\ProductoController as ClienteProductoController;
use App\Http\Controllers\Cliente\ReservaController as ClienteReservaController;
use App\Http\Controllers\Cliente\VentaController;

use App\Http\Controllers\Admin\BarberoController as AdminBarberoController;
use App\Http\Controllers\Admin\ProductoController as AdminProductoController;
use App\Http\Controllers\Admin\ReservaController as AdminReservaController;
use App\Http\Controllers\Admin\EmpleadoController;

use App\Http\Controllers\Empleado\DashboardController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Página pública
Route::get('/', function () {
    return view('welcome');
});

// Auth (una sola vez) con email verification activado
Auth::routes(['verify' => true]);

/*
|--------------------------------------------------------------------------
| Email verification routes (NOTICE + VERIFY + RESEND)
| - usamos closure para la "notice" para evitar dependencia a un controller que no exista
|--------------------------------------------------------------------------
*/
Route::get('/email/verify', function () {
    return view('auth.verify-email'); // crea esta vista si no existe
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $user = $request->user();

    if (!$user->correo_verificado_en) {
        $user->correo_verificado_en = now();
        $user->estado = 1; // si quieres activar estado al verificar
        $user->save();
    }

    // Redirigir según rol (admin/empleado no requieren verificación pero si vienen por el link...)
    if ($user->rol === 'admin') {
        return redirect()->route('admin');
    } elseif ($user->rol === 'empleado') {
        return redirect()->route('empleado.dashboard');
    } else {
        return redirect()->route('cliente.home')->with('status', '¡Correo verificado correctamente!');
    }

})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('message', 'Se ha enviado un nuevo enlace de verificación a tu correo.');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');


/*
|--------------------------------------------------------------------------
| PANEL ADMIN
|--------------------------------------------------------------------------
| - /admin (route name 'admin') accesible por admin|empleado
| - Rutas bajo /admin/... con middleware role:admin|empleado
| - Recursos de configuración (empleados) protegidos solo para admin
|--------------------------------------------------------------------------
*/

// Ruta principal /admin (nombre 'admin' — útil para redirects existentes)
Route::get('/admin', [DashboardController::class, 'index'])
    ->middleware(['auth', 'estado', 'role:admin|empleado'])
    ->name('admin');

// Grupo de rutas /admin/*
Route::middleware(['auth', 'role:admin|empleado'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        // Panel principal
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        // Rutas de recursos
        Route::resource('barberos', AdminBarberoController::class);
        Route::resource('productos', AdminProductoController::class);
        Route::resource('reservas', AdminReservaController::class);

        // Configuración
        Route::prefix('config')->group(function () {
            Route::resource('empleados', EmpleadoController::class);
            Route::view('settings', 'admin.settings')->name('settings');
        });
    });


/*
|--------------------------------------------------------------------------
| PANEL EMPLEADO
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'estado', 'role:empleado'])
    ->prefix('empleado')
    ->name('empleado.')
    ->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::resource('barberos', AdminBarberoController::class);
        Route::resource('productos', AdminProductoController::class);
        Route::resource('reservas', AdminReservaController::class);
    });


/*
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
        Route::get('/inicio', [ClienteHomeController::class, 'inicio'])->name('inicio');
    });

    // Acceso a funcionalidades del cliente
    Route::prefix('cliente')->name('cliente.')->group(function () {
        Route::get('/inicio', [ClienteHomeController::class, 'inicio'])->name('inicio');

    });
    Route::middleware(['auth', 'can:is-cliente'])->prefix('cliente')->name('cliente.')->group(function () {
    Route::get('/barberos', [ClienteBarberoController::class, 'index'])->name('barberos.index');

    Route::get('/reservas', [ClienteReservaController::class, 'misReservas'])->name('reservas');

});
Route::middleware(['auth', 'can:is-cliente'])->prefix('cliente')->name('cliente.')->group(function () {
    Route::get('/barberos', [ClienteBarberoController::class, 'index'])->name('barberos.index');
    Route::get('/reservar/{barbero}', [ClienteReservaController::class, 'create'])->name('reservar');
    Route::post('/reservar', [ClienteReservaController::class, 'store'])->name('reservar.store');
    Route::get('/reservas', [ClienteReservaController::class, 'misReservas'])->name('reservas');
});

Route::middleware(['auth', 'role:cliente'])->prefix('cliente')->name('cliente.')->group(function () {
    Route::post('/ventas', [VentaController::class, 'store'])->name('ventas.store');
    Route::get('/ventas/{venta}', [VentaController::class, 'show'])->name('ventas.show');
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
    Route::get('/ventas', [VentaController::class, 'index'])->name('ventas.index');
    Route::post('/ventas/agregar/{id}', [VentaController::class, 'agregar'])->name('ventas.agregar');
    Route::post('/ventas/eliminar/{id}', [VentaController::class, 'eliminar'])->name('ventas.eliminar');
    Route::post('/ventas/confirmar', [VentaController::class, 'confirmarCompra'])->name('ventas.confirmar');
    

    Route::post('/ventas/confirmar', [VentaController::class, 'confirmarCompra'])->name('venta.confirmar');
Route::post('/ventas/eliminar/{id}', [VentaController::class, 'eliminar'])->name('cliente.ventas.eliminar');

    
    
    // Productos
    Route::get('/productos', [ClienteProductoController::class, 'index'])->name('productos.index');
Route::get('/cliente/productos', [ClienteProductoController::class, 'index'])
    ->name('cliente.productos.index');

});
