<?php

/*
 * MateriaPrimaController - Controlador para materias primas (harinas, ingredientes)
 * Maneja la tabla 'materias_primas' con campos:
 * - nombre_materia: nombre del ingrediente (ej: Harina de trigo)
 * - unidad_fija: unidad de medida (kg, litros, etc.)
 * - stock_actual: cantidad disponible en inventario
 * - fecha_ingreso: cuando entró al almacén
 */

namespace App\Http\Controllers;

use App\Models\MateriaPrima;
use Illuminate\Http\Request;

class MateriaPrimaController extends Controller
{
    /*
     * index() - Lista todas las materias primas con sus productos relacionados
     * MateriaPrima = modelo de la tabla materias_primas
     */
    public function index()
    {
        $materias = MateriaPrima::with(['productos', 'detalleCompras'])->get();
        return response()->json($materias);
    }

    public function store(Request $request)
    {
        /*
         * store() - Crea nueva materia prima
         * Validación:
         * - nombre_materia: requerido, texto, máx 100 caracteres
         * - unidad_fija: requerido, entero, mínimo 1
         * - stock_actual: requerido, entero, mínimo 0
         * - fecha_ingreso: requerido, formato Y-m-d (ej: 2024-02-21)
         * date_format:Y-m-d = valida formato de fecha año-mes-día
         */
        $request->validate([
            'nombre_materia' => 'required|string|max:100',
            'unidad_fija' => 'required|integer|min:1',
            'stock_actual' => 'required|integer|min:0',
            'fecha_ingreso' => 'required|date_format:Y-m-d'
        ]);

        $materia = MateriaPrima::create($request->all());
        return response()->json($materia, 201);
    }

    /*
     * show() - Muestra una materia prima específica con sus relaciones
     * $id = id_materia de la URL
     */
    public function show($id)
    {
        $materia = MateriaPrima::with(['productos', 'detalleCompras'])->findOrFail($id);
        return response()->json($materia);
    }

    /*
     * update() - Modifica una materia prima existente
     * Recibe los mismos campos que store()
     */
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

    /*
     * destroy() - Elimina una materia prima
     * No debe usarse si hay productos que dependen de ella (verificar integridad referencial)
     */
    public function destroy($id)
    {
        $materia = MateriaPrima::findOrFail($id);
        $materia->delete();
        return response()->json(null, 204);
    }
}
