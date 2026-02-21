<?php

/*
 * ARCHIVO DE RUTAS - web.php
 * Este archivo define todas las URLs de la aplicación
 * 
 * Route::get() = ruta que responde a peticiones GET (obtener páginas)
 * Route::post() = ruta para CREAR datos (POST)
 * Route::put() = ruta para ACTUALIZAR datos (PUT)
 * Route::delete() = ruta para ELIMINAR datos (DELETE)
 * 
 * function() { return view('xxx'); } = retorna una vista Blade
 * [Controller::class, 'metodo'] = llama a un método de un controlador
 * {id} = parámetro dinámico de la URL (ej: /api/clientes/5)
 */

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PanaderiaController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\EmpleadoController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\MateriaPrimaController;
use App\Http\Controllers\CompraController;
use App\Http\Controllers\VentaController;

/* ============================================================
 * RUTAS DE VISTAS (PÁGINAS HTML)
 * Estas rutas retornan vistas Blade (.blade.php)
 * ============================================================ */

// Ruta principal - Página de inicio (Dashboard)
// Cuando el usuario va a /, carga la vista index.blade.php
Route::get('/', function () {
    return view('index');
});

// Panel de Administración - Vista admin/index.blade.php
Route::get('/admin', function () {
    return view('admin.index');
});

// Reporte de Ventas para gerente - Vista admin/ventas.blade.php
Route::get('/admin/ventas', function () {
    return view('admin.ventas');
});

// Terminal de Ventas - Donde se vende pan - Vista terminal/index.blade.php
Route::get('/terminal', function () {
    return view('terminal.index');
});

/* -----------------------------------------------------------
 * Rutas de vistas CRUD (Create Read Update Delete)
 * Cada una carga el index.blade.php de su carpeta
 * ----------------------------------------------------------- */
Route::get('/clientes', function () {
    return view('clientes.index');      // Vista de gestión de clientes
});

Route::get('/empleados', function () {
    return view('empleados.index');    // Vista de gestión de empleados
});

Route::get('/productos', function () {
    return view('productos.index');     // Vista de gestión de panes
});

Route::get('/materias-primas', function () {
    return view('materias_primas.index'); // Vista de gestión de ingredientes
});

Route::get('/compras', function () {
    return view('compras.index');       // Vista de compras a proveedores
});

Route::get('/ventas', function () {
    return view('ventas.index');        // Vista de historial de ventas
});

/* ============================================================
 * RUTAS DE API (RETORNAN JSON)
 * Estas rutas son para AJAX/JavaScript, retornan datos, no HTML
 * ============================================================ */

// API de estadísticas para el dashboard
Route::get('/api', [PanaderiaController::class, 'index']);
Route::get('/api/estadisticas', [PanaderiaController::class, 'estadisticas']);

/* -----------------------------------------------------------
 * RUTAS CRUD DE CLIENTES API
 * 
 * GET    /api/clientes      = lista todos los clientes (index)
 * POST   /api/clientes      = crea nuevo cliente (store)
 * GET    /api/clientes/{id} = muestra un cliente (show)
 * PUT    /api/clientes/{id} = actualiza cliente (update)
 * DELETE /api/clientes/{id} = elimina cliente (destroy)
 * ----------------------------------------------------------- */
Route::get('/api/clientes', [ClienteController::class, 'index']);
Route::post('/api/clientes', [ClienteController::class, 'store']);
Route::get('/api/clientes/{id}', [ClienteController::class, 'show']);
Route::put('/api/clientes/{id}', [ClienteController::class, 'update']);
Route::delete('/api/clientes/{id}', [ClienteController::class, 'destroy']);

/* -----------------------------------------------------------
 * RUTAS CRUD DE EMPLEADOS API
 * Incluye manejo de info_empleados (salarios)
 * ----------------------------------------------------------- */
Route::get('/api/empleados', [EmpleadoController::class, 'index']);
Route::post('/api/empleados', [EmpleadoController::class, 'store']);
Route::get('/api/empleados/{id}', [EmpleadoController::class, 'show']);
Route::put('/api/empleados/{id}', [EmpleadoController::class, 'update']);
Route::delete('/api/empleados/{id}', [EmpleadoController::class, 'destroy']);

/* -----------------------------------------------------------
 * RUTAS CRUD DE PRODUCTOS/PANES API
 * ----------------------------------------------------------- */
Route::get('/api/productos', [ProductoController::class, 'index']);
Route::post('/api/productos', [ProductoController::class, 'store']);
Route::get('/api/productos/{id}', [ProductoController::class, 'show']);
Route::put('/api/productos/{id}', [ProductoController::class, 'update']);
Route::delete('/api/productos/{id}', [ProductoController::class, 'destroy']);

/* -----------------------------------------------------------
 * RUTAS CRUD DE MATERIAS PRIMAS API
 * ----------------------------------------------------------- */
Route::get('/api/materias-primas', [MateriaPrimaController::class, 'index']);
Route::post('/api/materias-primas', [MateriaPrimaController::class, 'store']);
Route::get('/api/materias-primas/{id}', [MateriaPrimaController::class, 'show']);
Route::put('/api/materias-primas/{id}', [MateriaPrimaController::class, 'update']);
Route::delete('/api/materias-primas/{id}', [MateriaPrimaController::class, 'destroy']);

/* -----------------------------------------------------------
 * RUTAS CRUD DE COMPRAS API
 * ----------------------------------------------------------- */
Route::get('/api/compras', [CompraController::class, 'index']);
Route::post('/api/compras', [CompraController::class, 'store']);
Route::get('/api/compras/{id}', [CompraController::class, 'show']);
Route::put('/api/compras/{id}', [CompraController::class, 'update']);
Route::delete('/api/compras/{id}', [CompraController::class, 'destroy']);

/* -----------------------------------------------------------
 * RUTAS CRUD DE VENTAS API
 * Incluye manejo de detalles de venta (productos vendidos)
 * ----------------------------------------------------------- */
Route::get('/api/ventas', [VentaController::class, 'index']);
Route::post('/api/ventas', [VentaController::class, 'store']);
Route::get('/api/ventas/{id}', [VentaController::class, 'show']);
Route::put('/api/ventas/{id}', [VentaController::class, 'update']);
Route::delete('/api/ventas/{id}', [VentaController::class, 'destroy']);
