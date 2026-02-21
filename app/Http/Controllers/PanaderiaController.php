<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Empleado;
use App\Models\Producto;
use App\Models\MateriaPrima;
use App\Models\Compra;
use App\Models\Venta;

class PanaderiaController extends Controller
{
    public function index()
    {
        return response()->json([
            'mensaje' => 'API de Panadería funcionando',
            'endpoints' => [
                'clientes' => '/api/clientes',
                'empleados' => '/api/empleados',
                'productos' => '/api/productos',
                'materias_primas' => '/api/materias-primas',
                'compras' => '/api/compras',
                'ventas' => '/api/ventas',
                'estadisticas' => '/api/estadisticas'
            ]
        ]);
    }

    public function estadisticas()
    {
        return response()->json([
            'total_clientes' => Cliente::count(),
            'total_empleados' => Empleado::count(),
            'total_productos' => Producto::count(),
            'total_materias_primas' => MateriaPrima::count(),
            'total_compras' => Compra::count(),
            'total_ventas' => Venta::count(),
            'valor_total_compras' => Compra::sum('total_compra'),
            'valor_total_ventas' => Venta::sum('total_venta')
        ]);
    }
}
