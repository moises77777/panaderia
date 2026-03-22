<?php

namespace App\Http\Controllers;

use App\Models\Venta;
use App\Models\Cliente;
use App\Models\Empleado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class VentaController extends Controller
{

    public function index()
    {
        $user = Auth::user();
        
        // If user is cajera, show only their own sales
        if ($user->role === 'cajera') {
            $empleado = $user->empleado;
            if ($empleado) {
                $ventas = Venta::with(['cliente', 'empleado', 'detalles.producto'])
                    ->where('id_empleado', $empleado->id_empleado)
                    ->get();
            } else {
                $ventas = [];
            }
        } else {
            // Jefe can see all sales
            $ventas = Venta::with(['cliente', 'empleado', 'detalles.producto'])->get();
        }
        
        return response()->json($ventas);
    }

    public function misVentasHoy()
    {
        $user = Auth::user();
        
        // Get the empleado associated with the user
        $empleado = $user->empleado;
        
        if (!$empleado) {
            return response()->json([]);
        }
        
        // Get today's sales for this cajera
        $hoy = Carbon::today();
        $ventas = Venta::with(['cliente', 'detalles.producto'])
            ->where('id_empleado', $empleado->id_empleado)
            ->whereDate('fecha_venta', $hoy)
            ->orderBy('fecha_venta', 'desc')
            ->get();
        
        return response()->json($ventas);
    }

    public function storePublic(Request $request)
    {
        $request->validate([
            'fecha_venta' => 'nullable|date',
            'total_venta' => 'required|numeric|min:0',
            'notas' => 'nullable|string|max:255',
            'id_cliente' => 'required|exists:clientes,id_cliente',
            'detalles' => 'nullable|array'
        ]);

        $datos = $request->all();
        $datos['fecha_venta'] = $datos['fecha_venta'] ?? now();
        $datos['id_empleado'] = null; // No empleado for public sales

        $venta = Venta::create($datos);

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

        return response()->json($venta->load(['cliente', 'detalles']), 201);
    }

    public function store(Request $request)
    {

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

        $venta = Venta::create($datos);

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

        return response()->json($venta->load(['cliente', 'empleado', 'detalles']), 201);
    }

    public function show($id)
    {

        $venta = Venta::with(['cliente', 'empleado', 'detalles.producto'])->findOrFail($id);
        return response()->json($venta);
    }

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

    public function destroy($id)
    {

        $venta = Venta::findOrFail($id);
        $venta->delete();
        return response()->json(null, 204);
    }
}
