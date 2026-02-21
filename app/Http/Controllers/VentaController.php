<?php

/*
 * VentaController - Controlador para manejar ventas de pan
 * Maneja la tabla 'ventas' y 'detalle_venta'
 * Incluye lógica para reducir stock de productos al vender
 */

namespace App\Http\Controllers;

use App\Models\Venta;
use App\Models\Cliente;
use App\Models\Empleado;
use Illuminate\Http\Request;

class VentaController extends Controller
{
    /*
     * index() - Lista todas las ventas con sus relaciones
     * with(['cliente', 'empleado', 'detalles.producto']) = eager loading múltiple
     * Carga cliente, empleado, y los detalles con sus productos de una sola vez
     */
    public function index()
    {
        $ventas = Venta::with(['cliente', 'empleado', 'detalles.producto'])->get();
        return response()->json($ventas);
    }

    public function store(Request $request)
    {
        /*
         * store() - Crea una nueva venta con sus detalles
         * 
         * Validación:
         * - fecha_venta: nullable (opcional), debe ser fecha
         * - total_venta: requerido, numérico, mínimo 0
         * - notas: opcional, string máx 255 caracteres
         * - id_cliente: requerido, debe existir en tabla clientes
         * - id_empleado: requerido, debe existir en tabla empleados
         * - detalles: opcional, debe ser array
         * 
         * ?? now() = si no viene fecha, usa fecha/hora actual
         */
        $request->validate([
            'fecha_venta' => 'nullable|date',
            'total_venta' => 'required|numeric|min:0',
            'notas' => 'nullable|string|max:255',
            'id_cliente' => 'required|exists:clientes,id_cliente',
            'id_empleado' => 'required|exists:empleados,id_empleado',
            'detalles' => 'nullable|array'
        ]);

        $datos = $request->all();
        $datos['fecha_venta'] = $datos['fecha_venta'] ?? now();

        /* Venta::create() = INSERT INTO ventas */
        $venta = Venta::create($datos);

        /* 
         * Si hay detalles (productos vendidos), crea cada detalle y reduce stock
         * foreach = bucle para recorrer array de detalles
         * $venta->detalles()->create($detalle) = INSERT INTO detalle_venta con id_venta
         * \App\Models\Producto::find() = busca el producto para actualizar stock
         * $producto->stock_disponible -= $detalle['cantidad'] = RESTA del inventario
         */
        if (!empty($datos['detalles'])) {
            foreach ($datos['detalles'] as $detalle) {
                $venta->detalles()->create($detalle);
                
                $producto = \App\Models\Producto::find($detalle['id_pan']);
                if ($producto) {
                    $producto->stock_disponible -= $detalle['cantidad'];
                    $producto->save();
                }
            }
        }

        /* load() = carga relaciones después de crear para devolver en JSON */
        return response()->json($venta->load(['cliente', 'empleado', 'detalles']), 201);
    }

    /*
     * show() - Muestra una venta específica con todas sus relaciones
     * $id = id_venta que viene en la URL
     */
    public function show($id)
    {
        $venta = Venta::with(['cliente', 'empleado', 'detalles.producto'])->findOrFail($id);
        return response()->json($venta);
    }

    /*
     * update() - Modifica una venta existente
     * $request->all() = todos los campos que vienen en el formulario
     */
    public function update(Request $request, $id)
    {
        $venta = Venta::findOrFail($id);
        
        $request->validate([
            'fecha_venta' => 'required|date',
            'total_venta' => 'required|numeric|min:0',
            'notas' => 'nullable|string|max:255',
            'id_cliente' => 'required|exists:clientes,id_cliente',
            'id_empleado' => 'required|exists:empleados,id_empleado'
        ]);

        $venta->update($request->all());
        return response()->json($venta);
    }

    /*
     * destroy() - Elimina una venta
     * Al eliminar la venta, los detalles se borran por cascade (si está configurado en BD)
     */
    public function destroy($id)
    {
        $venta = Venta::findOrFail($id);
        $venta->delete();
        return response()->json(null, 204);
    }
}
