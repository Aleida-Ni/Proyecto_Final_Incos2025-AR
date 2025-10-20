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

// Admin Controllers
use App\Http\Controllers\Admin\VentaController;
use App\Http\Controllers\Admin\BarberoController as AdminBarberoController;
use App\Http\Controllers\Admin\ProductoController as AdminProductoController;
use App\Http\Controllers\Admin\ReservaController as AdminReservaController;
use App\Http\Controllers\Admin\ReporteController as ReporteController;
use App\Http\Controllers\Admin\EmpleadoController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;

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
    $request->fulfill();
    
    // Si es un cliente, actualizar su estado a 1
    if($request->user()->rol === 'cliente') {
        $request->user()->update(['estado' => 1]);
    }
    
    // Si el usuario es cliente
    if($request->user()->rol === 'cliente') {
        return redirect()->route('cliente.home')->with('verified', true);
    }
    
    // Si el usuario es admin
    if($request->user()->rol === 'admin') {
        return redirect()->route('admin.home')->with('verified', true);
    }
    
    return redirect('/')->with('verified', true);
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('message', 'Link de verificación enviado!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');


/* ==============================
   PANEL ADMIN
   ============================== */
Route::middleware(['auth', 'estado', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        // Panel principal
        Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');

        // Recursos
        Route::resource('barberos', AdminBarberoController::class);
        Route::resource('productos', AdminProductoController::class);
        Route::resource('reservas', AdminReservaController::class);

        // Completar reserva
        Route::get('reservas/{reserva}/completar', [AdminReservaController::class, 'showCompletar'])
            ->name('reservas.completar')
            ->whereNumber('reserva'); // importante para que funcione el model binding
        Route::post('reservas/{reserva}/completar', [AdminReservaController::class, 'completar'])
            ->name('reservas.completar.store')
            ->whereNumber('reserva');

        // Marcar reserva
        Route::post('reservas/{id}/{estado}', [AdminReservaController::class, 'marcar'])
            ->name('reservas.marcar')
            ->whereNumber('id');

        // Exportar Reportes PDF
        Route::get('reportes/reservas/pdf', [ReporteController::class, 'exportarReservasPDF'])
            ->name('reportes.reservas.pdf');

        // Ventas (admin)
        Route::prefix('ventas')->name('ventas.')->group(function () {
            Route::get('/', [VentaController::class, 'index'])->name('index');
            Route::get('/crear', [VentaController::class, 'create'])->name('create');
            Route::post('/', [VentaController::class, 'store'])->name('store');
            Route::get('/{venta}', [VentaController::class, 'show'])->name('show');
            Route::delete('/{venta}', [VentaController::class, 'destroy'])->name('destroy');
        });

        // Configuración (admin)
        Route::prefix('config')->group(function () {
            Route::resource('empleados', EmpleadoController::class);
            Route::view('settings', 'admin.settings')->name('settings');
        });

        // Reportes (admin)
        Route::prefix('reportes')->name('reportes.')->group(function () {
            Route::get('/reservas', [ReporteController::class, 'reservas'])->name('reservas');
            Route::get('/ventas',   [ReporteController::class, 'ventas'])->name('ventas');
            Route::get('/ventas/pdf', [ReporteController::class, 'exportarVentasPDF'])->name('ventas.pdf');
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
        Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');

        // Recursos
        Route::resource('barberos', AdminBarberoController::class);
        Route::resource('productos', AdminProductoController::class);
        Route::resource('reservas', AdminReservaController::class);

        // Completar reserva
        Route::get('reservas/{reserva}/completar', [AdminReservaController::class, 'showCompletar'])
            ->name('reservas.completar')
            ->whereNumber('reserva');
        Route::post('reservas/{reserva}/completar', [AdminReservaController::class, 'completar'])
            ->name('reservas.completar.store')
            ->whereNumber('reserva');

        // Marcar reserva
        Route::post('reservas/{id}/{estado}', [AdminReservaController::class, 'marcar'])
            ->name('reservas.marcar')
            ->whereNumber('id');

        // Ventas (empleado)
        Route::prefix('ventas')->name('ventas.')->group(function () {
            Route::get('/crear', [VentaController::class, 'create'])->name('create');
            Route::post('/', [VentaController::class, 'store'])->name('store');
            Route::delete('/{venta}', [VentaController::class, 'destroy'])->name('destroy');
        });
    });

/* PANEL CLIENTE */
Route::middleware(['auth', 'verified'])
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
        Route::prefix('config')->name('config.')->group(function () {
            // Esta ruta debe existir
            Route::resource('empleados', EmpleadoController::class);
            Route::view('settings', 'admin.settings')->name('settings');
        });


        // Barberos / Reservas
        Route::get('/barberos', [ClienteBarberoController::class, 'index'])->name('barberos.index');
        Route::get('/reservar/{barbero}', [ClienteReservaController::class, 'create'])->name('reservar');
        Route::post('/reservar', [ClienteReservaController::class, 'store'])->name('reservar.store');
        Route::get('/reservas', [ClienteReservaController::class, 'misReservas'])->name('reservas');
        // Cancelar reserva por cliente
        Route::post('/reservas/{reserva}/cancelar', [ClienteReservaController::class, 'cancelar'])
            ->name('reservas.cancelar')
            ->whereNumber('reserva');
Route::post('/limpiar-sesion-ticket', function() {
    session()->forget('reserva_creada');
    return response()->json(['success' => true]);
})->name('limpiar.sesion.ticket');
});

