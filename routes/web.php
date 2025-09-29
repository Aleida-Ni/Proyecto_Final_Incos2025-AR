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
use App\Http\Controllers\Admin\ReporteController as ReporteController;
use App\Http\Controllers\Admin\EmpleadoController;
use App\Http\Controllers\Admin\ProductoController;

use App\Http\Controllers\Empleado\DashboardController;
use App\Http\Controllers\Empleado\ProductoController as EmpleadoProductoController;

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
    return view('auth.verify'); // crea esta vista si no existe
})->middleware('auth')->name('verification.notice');

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

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('message', 'Se ha enviado un nuevo enlace de verificación a tu correo.');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');


/*PANEL ADMIN*/

// Grupo de rutas /admin/*
Route::middleware(['auth', 'role:admin|empleado'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        // Panel principal
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        // Rutas de recursos principales
        Route::resource('barberos', AdminBarberoController::class);
        Route::resource('productos', ProductoController::class);
        Route::resource('reservas', AdminReservaController::class);

        // Ruta para marcar reservas como realizada o no asistió
        Route::post('reservas/{id}/{estado}', [App\Http\Controllers\Admin\ReservaController::class, 'marcar'])
            ->name('reservas.marcar');

        // Configuración
        Route::prefix('config')->group(function () {
            Route::resource('empleados', EmpleadoController::class);
            Route::view('settings', 'admin.settings')->name('settings');
        });

        // Reportes
        Route::prefix('reportes')->name('reportes.')->group(function () {
            Route::get('/reservas', [ReporteController::class, 'reservas'])->name('reservas');
            Route::get('/ventas',   [ReporteController::class, 'ventas'])->name('ventas');
        });
    });




/*PANEL EMPLEADO*/
Route::middleware(['auth', 'estado', 'role:empleado'])
    ->prefix('empleado')
    ->name('empleado.')
    ->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::resource('barberos', AdminBarberoController::class);
        Route::resource('productos', AdminProductoController::class);
        Route::resource('reservas', AdminReservaController::class);
    });

/*PANEL CLIENTE*/
Route::middleware(['auth', 'verified', 'estado','can:is-cliente'])
    ->prefix('cliente')
    ->name('cliente.')
    ->group(function () {

        Route::get('/home', function () {
            $barberos = Barbero::all();
            return view('cliente.home', compact('barberos'));
        })->name('home');

        // Página de inicio 
        Route::get('/inicio', [ClienteHomeController::class, 'inicio'])->name('inicio');

        // Barberos / Reservas
        Route::get('/barberos', [ClienteBarberoController::class, 'index'])->name('barberos.index');
        Route::get('/reservar/{barbero}', [ClienteReservaController::class, 'create'])->name('reservar');
        Route::post('/reservar', [ClienteReservaController::class, 'store'])->name('reservar.store');
        Route::get('/reservas', [ClienteReservaController::class, 'misReservas'])->name('reservas');

        // Modal / fragmento del carrito (AJAX)
        Route::get('/ventas/carrito', [VentaController::class, 'modalCarrito'])->name('ventas.carrito');

        // Ver carrito completo
        Route::get('/ventas', [VentaController::class, 'index'])->name('ventas.index');

        // Acciones del carrito
        Route::post('/ventas/agregar/{producto}', [VentaController::class, 'agregar'])->name('ventas.agregar');
        Route::post('/ventas/eliminar/{producto}', [VentaController::class, 'eliminar'])->name('ventas.eliminar');
        Route::post('/ventas/aumentar/{producto}', [VentaController::class, 'aumentar'])->name('ventas.aumentar');
        Route::post('/ventas/disminuir/{producto}', [VentaController::class, 'disminuir'])->name('ventas.disminuir');
        Route::post('/ventas/vaciar', [VentaController::class, 'vaciar'])->name('ventas.vaciar');
        Route::get('/productos', [App\Http\Controllers\Cliente\ProductoController::class, 'index'])
            ->name('productos.index');
        // Confirmar compra 
        Route::post('/ventas/confirmar', [VentaController::class, 'confirmarCompra'])->name('ventas.confirmar');
        Route::get('/ventas/exito/{venta}', [VentaController::class, 'exito'])->name('ventas.exito');
    });
