<?php

namespace App\Http\Controllers;

use App\Models\Compra;
use App\Models\Empleado;
use Illuminate\Http\Request;

class CompraController extends Controller
{
    public function index()
    {
        $compras = Compra::with(['empleado', 'detalles.materiaPrima'])->get();
        return response()->json($compras);
    }

    public function store(Request $request)
    {
        $request->validate([
            'fecha_compra' => 'required|date',
            'total_compra' => 'required|numeric|min:0',
            'notas' => 'nullable|string|max:255',
            'id_empleado' => 'required|exists:empleados,id_empleado'
        ]);

        $compra = Compra::create($request->all());
        return response()->json($compra, 201);
    }

    public function show($id)
    {
        $compra = Compra::with(['empleado', 'detalles.materiaPrima'])->findOrFail($id);
        return response()->json($compra);
    }

    public function update(Request $request, $id)
    {
        $compra = Compra::findOrFail($id);
        
        $request->validate([
            'fecha_compra' => 'required|date',
            'total_compra' => 'required|numeric|min:0',
            'notas' => 'nullable|string|max:255',
            'id_empleado' => 'required|exists:empleados,id_empleado'
        ]);

        $compra->update($request->all());
        return response()->json($compra);
    }

    public function destroy($id)
    {
        $compra = Compra::findOrFail($id);
        $compra->delete();
        return response()->json(null, 204);
    }
}
