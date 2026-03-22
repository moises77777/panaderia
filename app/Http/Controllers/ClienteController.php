<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ClienteController extends Controller
{

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

        try {
            // Accept both 'nombre' and 'nombre_cliente' fields
            $nombre = $request->input('nombre') ?? $request->input('nombre_cliente');

            if (!$nombre) {
                return response()->json(['error' => 'nombre requerido'], 422);
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

        try {
            $cliente = Cliente::with('ventas')->findOrFail($id);
            return response()->json($cliente);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Cliente no encontrado'], 404);
        }
    }

    public function update(Request $request, $id)
    {

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

        try {
            $cliente = Cliente::findOrFail($id);
            $cliente->delete();
            return response()->json(null, 204);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
