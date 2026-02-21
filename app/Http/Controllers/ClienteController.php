<?php

/*
 * ClienteController - Controlador para manejar operaciones CRUD de clientes
 * Maneja la tabla 'clientes' con campo 'nombre'
 */

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ClienteController extends Controller
{
    /*
     * index() - Obtiene TODOS los clientes de la base de datos
     * Cliente::all() = SELECT * FROM clientes
     * Retorna JSON con array de clientes
     */
    public function index()
    {
        try {
            $clientes = Cliente::all();
            return response()->json($clientes);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function store(Request $request)
    {
        /*
         * store() - Crea un nuevo cliente
         * $request->input('nombre_cliente') = obtiene el campo del formulario/API
         * new Cliente() = crea objeto vacío del modelo
         * $cliente->save() = INSERT INTO clientes
         * 201 = código HTTP "Created" (creado exitosamente)
         */
        try {
            $nombre = $request->input('nombre_cliente');
            if (!$nombre) {
                return response()->json(['error' => 'nombre_cliente requerido'], 422);
            }

            $cliente = new Cliente();
            $cliente->nombre = $nombre;
            $cliente->save();

            return response()->json($cliente, 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()], 500);
        }
    }

    public function show($id)
    {
        /*
         * show($id) - Muestra UN cliente específico con sus ventas
         * $id = ID del cliente que viene en la URL (/api/clientes/5)
         * with('ventas') = eager loading de la relación ventas
         * findOrFail($id) = busca o devuelve error 404
         */
        try {
            $cliente = Cliente::with('ventas')->findOrFail($id);
            return response()->json($cliente);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Cliente no encontrado'], 404);
        }
    }

    public function update(Request $request, $id)
    {
        /*
         * update() - Modifica un cliente existente
         * $request->validate() = valida datos antes de actualizar
         * $cliente->update() = UPDATE clientes SET ... WHERE id = $id
         * ValidationException = error cuando los datos no cumplen reglas
         */
        try {
            $cliente = Cliente::findOrFail($id);
            
            $request->validate([
                'nombre' => 'required|string|max:100'
            ]);

            $cliente->update($request->all());
            return response()->json($cliente);
        } catch (ValidationException $e) {
            return response()->json(['error' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        /*
         * destroy() - Elimina un cliente
         * $cliente->delete() = DELETE FROM clientes WHERE id = $id
         * 204 = No Content (éxito sin datos que devolver)
         */
        try {
            $cliente = Cliente::findOrFail($id);
            $cliente->delete();
            return response()->json(null, 204);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
