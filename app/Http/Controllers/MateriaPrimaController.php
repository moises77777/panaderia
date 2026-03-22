<?php

namespace App\Http\Controllers;

use App\Models\MateriaPrima;
use Illuminate\Http\Request;

class MateriaPrimaController extends Controller
{

    public function index()
    {
        $materias = MateriaPrima::with(['productos', 'detalleCompras'])->get();
        return response()->json($materias);
    }

    public function store(Request $request)
    {

        $request->validate([
            'nombre_materia' => 'required|string|max:100',
            'unidad_fija' => 'required|integer|min:1',
            'stock_actual' => 'required|integer|min:0',
            'fecha_ingreso' => 'required|date_format:Y-m-d'
        ]);

        $materia = MateriaPrima::create($request->all());
        return response()->json($materia, 201);
    }

    public function show($id)
    {

        $materia = MateriaPrima::with(['productos', 'detalleCompras'])->findOrFail($id);
        return response()->json($materia);
    }

    public function update(Request $request, $id)
    {

        $materia = MateriaPrima::findOrFail($id);

        $request->validate([
            'nombre_materia' => 'required|string|max:100',
            'unidad_fija' => 'required|integer|min:1',
            'stock_actual' => 'required|integer|min:0',
            'fecha_ingreso' => 'required|date_format:Y-m-d'
        ]);

        $materia->update($request->all());
        return response()->json($materia);
    }

    public function destroy($id)
    {

        $materia = MateriaPrima::findOrFail($id);
        $materia->delete();
        return response()->json(null, 204);
    }
}
