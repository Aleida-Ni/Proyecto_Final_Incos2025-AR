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
use App\Http\Controllers\Admin\VentaController;


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


/* ==============================
   PANEL ADMIN
   ============================== */
Route::middleware(['auth', 'estado', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        // Panel principal
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        // Recursos
        Route::resource('barberos', AdminBarberoController::class);
        Route::resource('productos', AdminProductoController::class);
        Route::resource('reservas', AdminReservaController::class);

        // Marcar reservas
        Route::post('reservas/{id}/{estado}', [AdminReservaController::class, 'marcar'])
            ->name('reservas.marcar');

        // Ventas (admin)
        Route::prefix('ventas')->name('ventas.')->group(function () {
            Route::get('/', [VentaController::class, 'index'])->name('index');
            Route::get('/crear', [VentaController::class, 'create'])->name('create');
            Route::post('/', [VentaController::class, 'store'])->name('store');
            Route::get('/{venta}', [VentaController::class, 'show'])->name('show');
             Route::delete('/{venta}', [VentaController::class, 'destroy'])->name('destroy');
        });

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


/* ==============================
   PANEL EMPLEADO
   ============================== */
Route::middleware(['auth', 'estado', 'role:empleado'])
    ->prefix('empleado')
    ->name('empleado.')
    ->group(function () {

        // Panel principal
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // Recursos
        Route::resource('barberos', AdminBarberoController::class);
        Route::resource('productos', AdminProductoController::class);
        Route::resource('reservas', AdminReservaController::class);

        // Ventas (empleado)
        Route::prefix('ventas')->name('ventas.')->group(function () {
            Route::get('/crear', [VentaController::class, 'create'])->name('create');
            Route::post('/', [VentaController::class, 'store'])->name('store');
             Route::delete('/{venta}', [VentaController::class, 'destroy'])->name('destroy');
        });
    });

/* PANEL CLIENTE */
Route::middleware(['auth', 'verified', 'estado', 'can:is-cliente'])
    ->prefix('cliente')
    ->name('cliente.')
    ->group(function () {

        // Página de inicio / Home
        Route::get('/home', function () {
            $barberos = Barbero::all();
            return view('cliente.home', compact('barberos'));
        })->name('home');

        Route::get('/inicio', [ClienteHomeController::class, 'inicio'])->name('inicio');

        // Productos
        Route::get('/productos', [App\Http\Controllers\Cliente\ProductoController::class, 'index'])
            ->name('productos.index');



        // Barberos / Reservas
        Route::get('/barberos', [ClienteBarberoController::class, 'index'])->name('barberos.index');
        Route::get('/reservar/{barbero}', [ClienteReservaController::class, 'create'])->name('reservar');
        Route::post('/reservar', [ClienteReservaController::class, 'store'])->name('reservar.store');
        Route::get('/reservas', [ClienteReservaController::class, 'misReservas'])->name('reservas');

});

