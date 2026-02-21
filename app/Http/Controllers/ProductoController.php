<?php

/*
 * ProductoController - Controlador para manejar productos/panes
 * Maneja la tabla 'panes' con campos: nombre_pan, precio, stock_disponible
 * Relación muchos a muchos con materias_primas (ingredientes)
 */

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    /*
     * index() - Lista todos los panes con sus materias primas y detalles de ventas
     * Producto = modelo de la tabla 'panes'
     */
    public function index()
    {
        $productos = Producto::with(['materiasPrimas', 'detalleVentas'])->get();
        return response()->json($productos);
    }

    public function store(Request $request)
    {
        /*
         * store() - Crea un nuevo producto/pan
         * Validación:
         * - nombre_pan: requerido, texto, máx 100 caracteres
         * - precio: requerido, numérico, mínimo 0
         * - stock_disponible: requerido, entero, mínimo 0
         * integer = número entero (sin decimales)
         */
        $request->validate([
            'nombre_pan' => 'required|string|max:100',
            'precio' => 'required|numeric|min:0',
            'stock_disponible' => 'required|integer|min:0'
        ]);

        $producto = Producto::create($request->all());
        return response()->json($producto, 201);
    }

    /*
     * show() - Muestra un pan específico con sus materias primas
     * $id = id_pan de la URL
     */
    public function show($id)
    {
        $producto = Producto::with(['materiasPrimas', 'detalleVentas'])->findOrFail($id);
        return response()->json($producto);
    }

    /*
     * update() - Modifica un pan existente
     * $request->all() = toma nombre_pan, precio, stock_disponible del formulario
     */
    public function update(Request $request, $id)
    {
        $producto = Producto::findOrFail($id);
        
        $request->validate([
            'nombre_pan' => 'required|string|max:100',
            'precio' => 'required|numeric|min:0',
            'stock_disponible' => 'required|integer|min:0'
        ]);

        $producto->update($request->all());
        return response()->json($producto);
    }

    /*
     * destroy() - Elimina un pan
     * 204 = código HTTP No Content (éxito sin body)
     */
    public function destroy($id)
    {
        $producto = Producto::findOrFail($id);
        $producto->delete();
        return response()->json(null, 204);
    }
}
