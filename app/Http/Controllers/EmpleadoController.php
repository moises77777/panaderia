<?php

namespace App\Http\Controllers;

use App\Models\Empleado;
use App\Models\InfoEmpleado;
use Illuminate\Http\Request;

class EmpleadoController extends Controller
{

    public function index()
    {
        try {
            $empleados = Empleado::with(['compras', 'ventas', 'infoEmpleado'])->get();
            return response()->json($empleados);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function store(Request $request)
    {

        try {
            $request->validate([
                'nombre_empleado' => 'required|string|max:100',
                'rol' => 'required|string|max:100',
                'fecha_ingreso' => 'required|date',
                'info' => 'nullable|array'
            ]);

            $empleado = Empleado::create($request->only(['nombre_empleado', 'rol', 'fecha_ingreso']));

            if (!empty($request->info)) {
                InfoEmpleado::create([
                    'id_empleado' => $empleado->id_empleado,
                    'salario' => $request->info['salario'] ?? 0,
                    'telefono' => $request->info['telefono'] ?? null,
                    'estado' => $request->info['estado'] ?? 'activo',
                    'fecha_contratacion' => $request->info['fecha_contratacion'] ?? $request->fecha_ingreso
                ]);
            }

            return response()->json($empleado->load('infoEmpleado'), 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['error' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function show($id)
    {

        $empleado = Empleado::with(['compras', 'ventas', 'infoEmpleado'])->findOrFail($id);
        return response()->json($empleado);
    }

    public function update(Request $request, $id)
    {

        $empleado = Empleado::findOrFail($id);

        $request->validate([
            'nombre_empleado' => 'required|string|max:100',
            'rol' => 'required|string|max:100',
            'fecha_ingreso' => 'required|date',
            'info' => 'nullable|array'
        ]);

        $empleado->update($request->only(['nombre_empleado', 'rol', 'fecha_ingreso']));

        if (!empty($request->info)) {
            $info = InfoEmpleado::firstOrNew(['id_empleado' => $empleado->id_empleado]);
            $info->salario = $request->info['salario'] ?? $info->salario ?? 0;
            $info->telefono = $request->info['telefono'] ?? $info->telefono;
            $info->estado = $request->info['estado'] ?? $info->estado ?? 'activo';
            $info->fecha_contratacion = $request->info['fecha_contratacion'] ?? $info->fecha_contratacion ?? $request->fecha_ingreso;
            $info->save();
        }

        return response()->json($empleado->load('infoEmpleado'));
    }

    public function destroy($id)
    {

        $empleado = Empleado::findOrFail($id);
        $empleado->delete();
        return response()->json(null, 204);
    }
}
