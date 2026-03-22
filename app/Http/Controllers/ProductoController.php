<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductoController extends Controller
{

    public function index()
    {
        $productos = Producto::with(['materiasPrimas', 'detalleVentas'])->get();
        return response()->json($productos);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre_pan' => 'required|string|max:100',
            'precio' => 'required|numeric|min:0',
            'stock_disponible' => 'required|integer|min:0',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $datos = $request->only(['nombre_pan', 'precio', 'stock_disponible']);

        // Manejar subida de imagen
        if ($request->hasFile('imagen')) {
            $imagen = $request->file('imagen');
            $nombreImagen = time() . '_' . $imagen->getClientOriginalName();
            $imagen->storeAs('public/productos', $nombreImagen);
            $datos['imagen'] = 'productos/' . $nombreImagen;
        }

        $producto = Producto::create($datos);
        return response()->json($producto, 201);
    }

    public function show($id)
    {

        $producto = Producto::with(['materiasPrimas', 'detalleVentas'])->findOrFail($id);
        return response()->json($producto);
    }

    public function update(Request $request, $id)
    {
        $producto = Producto::findOrFail($id);

        $request->validate([
            'nombre_pan' => 'required|string|max:100',
            'precio' => 'required|numeric|min:0',
            'stock_disponible' => 'required|integer|min:0',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $datos = $request->only(['nombre_pan', 'precio', 'stock_disponible']);

        // Manejar subida de imagen
        if ($request->hasFile('imagen')) {
            // Eliminar imagen anterior si existe
            if ($producto->imagen && Storage::exists('public/' . $producto->imagen)) {
                Storage::delete('public/' . $producto->imagen);
            }
            
            $imagen = $request->file('imagen');
            $nombreImagen = time() . '_' . $imagen->getClientOriginalName();
            $imagen->storeAs('public/productos', $nombreImagen);
            $datos['imagen'] = 'productos/' . $nombreImagen;
        }

        $producto->update($datos);
        return response()->json($producto);
    }

    public function destroy($id)
    {
        $producto = Producto::findOrFail($id);
        
        // Eliminar imagen si existe
        if ($producto->imagen && Storage::exists('public/' . $producto->imagen)) {
            Storage::delete('public/' . $producto->imagen);
        }
        
        $producto->delete();
        return response()->json(null, 204);
    }
}
