<?php

/*
 * EmpleadoController - Controlador para manejar operaciones CRUD de empleados
 * Incluye manejo de la tabla relacionada info_empleados para salarios y datos adicionales
 */

namespace App\Http\Controllers;

use App\Models\Empleado;
use App\Models\InfoEmpleado;
use Illuminate\Http\Request;

class EmpleadoController extends Controller
{
    /*
     * index() - Obtiene todos los empleados con sus relaciones
     * Empleado::with(['compras', 'ventas', 'infoEmpleado']) = eager loading (carga relaciones de una vez)
     * response()->json($empleados) = devuelve JSON para la API
     */
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
        /*
         * try-catch = manejo de errores para devolver JSON en lugar de error HTML
         * $request->validate() = valida que vengan los campos requeridos
         * required = campo obligatorio, string = debe ser texto, max:100 = máximo 100 caracteres
         * nullable = campo opcional, array = debe ser un arreglo
         */
        try {
            $request->validate([
                'nombre_empleado' => 'required|string|max:100',
                'rol' => 'required|string|max:100',
                'fecha_ingreso' => 'required|date',
                'info' => 'nullable|array'
            ]);

            /*
             * Empleado::create() = inserta nuevo registro en tabla empleados
             * $request->only(['...']) = solo toma los campos especificados del formulario
             */
            $empleado = Empleado::create($request->only(['nombre_empleado', 'rol', 'fecha_ingreso']));

            /*
             * Si viene info adicional (salario, etc.), crea registro en info_empleados
             * InfoEmpleado::create() = inserta en tabla info_empleados
             * ?? 0 = operador null coalescing (si es null, usa 0)
             * $empleado->id_empleado = obtiene el ID del empleado recién creado
             */
            if (!empty($request->info)) {
                InfoEmpleado::create([
                    'id_empleado' => $empleado->id_empleado,
                    'salario' => $request->info['salario'] ?? 0,
                    'telefono' => $request->info['telefono'] ?? null,
                    'estado' => $request->info['estado'] ?? 'activo',
                    'fecha_contratacion' => $request->info['fecha_contratacion'] ?? $request->fecha_ingreso
                ]);
            }

            /*
             * $empleado->load('infoEmpleado') = carga la relación después de crear
             * 201 = código HTTP para "Created" (creado exitosamente)
             */
            return response()->json($empleado->load('infoEmpleado'), 201);
        /*
         * \Illuminate\Validation\ValidationException = error de validación (datos incorrectos)
         * 422 = código HTTP "Unprocessable Entity" (datos inválidos)
         * \Exception = cualquier otro error
         * 500 = código HTTP "Internal Server Error"
         */
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['error' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function show($id)
    {
        /*
         * findOrFail($id) = busca el empleado, si no existe devuelve error 404
         * with(['compras', 'ventas', 'infoEmpleado']) = carga las relaciones de una vez
         */
        $empleado = Empleado::with(['compras', 'ventas', 'infoEmpleado'])->findOrFail($id);
        return response()->json($empleado);
    }

    public function update(Request $request, $id)
    {
        /*
         * findOrFail() = busca el empleado a actualizar
         */
        $empleado = Empleado::findOrFail($id);
        
        $request->validate([
            'nombre_empleado' => 'required|string|max:100',
            'rol' => 'required|string|max:100',
            'fecha_ingreso' => 'required|date',
            'info' => 'nullable|array'
        ]);

        /*
         * update() = actualiza solo los campos especificados en la tabla empleados
         */
        $empleado->update($request->only(['nombre_empleado', 'rol', 'fecha_ingreso']));

        /*
         * Actualizar info adicional si viene
         * firstOrNew() = busca el registro, si no existe crea uno nuevo
         * save() = guarda los cambios en la base de datos
         */
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
        /*
         * delete() = elimina el registro de la base de datos
         * 204 = código HTTP "No Content" (eliminado exitosamente, sin contenido que devolver)
         */
        $empleado = Empleado::findOrFail($id);
        $empleado->delete();
        return response()->json(null, 204);
    }
}
