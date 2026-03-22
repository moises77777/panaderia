<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\PanaderiaController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\EmpleadoController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\MateriaPrimaController;
use App\Http\Controllers\CompraController;
use App\Http\Controllers\VentaController;
use App\Http\Controllers\AuthController;

// Public API routes (customers) - CSRF tokens provided in JavaScript
Route::get('/api/productos', [ProductoController::class, 'index']);
Route::post('/api/clientes', [ClienteController::class, 'store']);
Route::get('/api/clientes', [ClienteController::class, 'index']);
Route::post('/api/ventas-publico', [VentaController::class, 'storePublic']);

Route::get('/terminal', function () {
    return view('terminal.index');
});

// Authentication routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Protected routes (staff only)
Route::middleware(['auth'])->group(function () {
    Route::get('/', function () {
        return view('index');
    });

    // User profile route - for all authenticated users
    Route::get('/perfil', function () {
        return view('perfil');
    });
    Route::put('/perfil', [AuthController::class, 'updateProfile']);

    // Admin routes (jefe only)
    Route::middleware(['role:jefe'])->prefix('admin')->group(function () {
        Route::get('/', function () {
            return view('admin.index');
        });
        Route::get('/ventas', function () {
            return view('admin.ventas');
        });
    });

    // API routes - accessible for all authenticated users
    Route::get('/api', [PanaderiaController::class, 'index']);
    Route::get('/api/estadisticas', [PanaderiaController::class, 'estadisticas']);

    Route::get('/api/clientes', [ClienteController::class, 'index']);
    Route::post('/api/clientes', [ClienteController::class, 'store']);
    Route::get('/api/clientes/{id}', [ClienteController::class, 'show']);
    Route::put('/api/clientes/{id}', [ClienteController::class, 'update']);
    Route::delete('/api/clientes/{id}', [ClienteController::class, 'destroy']);

    Route::get('/api/empleados', [EmpleadoController::class, 'index']);
    Route::post('/api/empleados', [EmpleadoController::class, 'store']);
    Route::get('/api/empleados/{id}', [EmpleadoController::class, 'show']);
    Route::put('/api/empleados/{id}', [EmpleadoController::class, 'update']);
    Route::delete('/api/empleados/{id}', [EmpleadoController::class, 'destroy']);

    Route::get('/api/productos', [ProductoController::class, 'index']);
    Route::post('/api/productos', [ProductoController::class, 'store']);
    Route::get('/api/productos/{id}', [ProductoController::class, 'show']);
    Route::put('/api/productos/{id}', [ProductoController::class, 'update']);
    Route::delete('/api/productos/{id}', [ProductoController::class, 'destroy']);

    Route::get('/api/materias-primas', [MateriaPrimaController::class, 'index']);
    Route::post('/api/materias-primas', [MateriaPrimaController::class, 'store']);
    Route::get('/api/materias-primas/{id}', [MateriaPrimaController::class, 'show']);
    Route::put('/api/materias-primas/{id}', [MateriaPrimaController::class, 'update']);
    Route::delete('/api/materias-primas/{id}', [MateriaPrimaController::class, 'destroy']);

    Route::get('/api/compras', [CompraController::class, 'index']);
    Route::post('/api/compras', [CompraController::class, 'store']);
    Route::get('/api/compras/{id}', [CompraController::class, 'show']);
    Route::put('/api/compras/{id}', [CompraController::class, 'update']);
    Route::delete('/api/compras/{id}', [CompraController::class, 'destroy']);

    Route::get('/api/ventas', [VentaController::class, 'index']);
    Route::post('/api/ventas', [VentaController::class, 'store']);
    Route::get('/api/ventas/{id}', [VentaController::class, 'show']);
    Route::put('/api/ventas/{id}', [VentaController::class, 'update']);
    Route::delete('/api/ventas/{id}', [VentaController::class, 'destroy']);

    // Other management routes (jefe only)
    Route::middleware(['role:jefe'])->group(function () {
        Route::get('/clientes', function () {
            return view('clientes.index');
        });
        Route::get('/empleados', function () {
            return view('empleados.index');
        });
        Route::get('/productos', function () {
            return view('productos.index');
        });
        Route::get('/materias-primas', function () {
            return view('materias_primas.index');
        });
        Route::get('/compras', function () {
            return view('compras.index');
        });
        Route::get('/ventas', function () {
            return view('ventas.index');
        });
    });

    Route::get('/api/user-info', function () {
        $user = Auth::user();
        $empleado = $user->empleado;
        return response()->json([
            'name' => $user->name,
            'role' => $user->role,
            'empleado_id' => $empleado ? $empleado->id_empleado : null,
        ]);
    });

    Route::get('/api/ventas', [VentaController::class, 'index']);
    Route::get('/api/mis-ventas-hoy', [VentaController::class, 'misVentasHoy']);
    Route::post('/api/ventas', [VentaController::class, 'store']);
    Route::get('/api/ventas/{id}', [VentaController::class, 'show']);
    Route::put('/api/ventas/{id}', [VentaController::class, 'update']);
    Route::delete('/api/ventas/{id}', [VentaController::class, 'destroy']);

    // Public API routes for terminal (no auth required)
    Route::get('/api/productos-public', [ProductoController::class, 'index']);
    Route::get('/api/clientes-public', [ClienteController::class, 'index']);
    Route::post('/api/clientes-public', [ClienteController::class, 'store']);
    Route::post('/api/ventas-public', [VentaController::class, 'storePublic']);
});
