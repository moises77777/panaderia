<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Cliente;
use App\Models\Empleado;
use App\Models\Producto;
use App\Models\MateriaPrima;
use App\Models\MaterialOcupado;
use App\Models\Compra;
use App\Models\DetalleCompra;
use App\Models\Venta;
use App\Models\DetalleVenta;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        // User::factory(10)->create();
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        // Crear clientes
        $clientes = Cliente::factory(5)->create();

        // Crear empleados
        $empleados = Empleado::factory(3)->create();

        // Crear materias primas
        $materiasPrimas = MateriaPrima::factory(10)->create();

        // Crear productos
        $productos = Producto::factory(8)->create();

        // Asignar materias primas a productos
        foreach ($productos as $producto) {
            $materiasAsignadas = $materiasPrimas->random(rand(2, 4));
            foreach ($materiasAsignadas as $materia) {
                MaterialOcupado::create([
                    'id_pan' => $producto->id_pan,
                    'id_materia_prima' => $materia->id_materia_prima,
                    'cantidad' => rand(1, 5)
                ]);
            }
        }

        // Crear compras
        foreach (range(1, 5) as $index) {
            $compra = Compra::create([
                'fecha_compra' => now()->subDays(rand(1, 30)),
                'total_compra' => 0,
                'notas' => 'Compra de materias primas #' . $index,
                'id_empleado' => $empleados->random()->id_empleado
            ]);

            $total = 0;
            $materiasCompradas = $materiasPrimas->random(rand(2, 4));
            foreach ($materiasCompradas as $materia) {
                $cantidad = rand(10, 50);
                $precioUnitario = rand(5, 50);
                $subtotal = $cantidad * $precioUnitario;
                $total += $subtotal;

                DetalleCompra::create([
                    'id_compra' => $compra->id_compra,
                    'id_materia_prima' => $materia->id_materia_prima,
                    'cantidad' => $cantidad,
                    'precio_unitario' => $precioUnitario,
                    'subtotal' => $subtotal
                ]);
            }

            $compra->update(['total_compra' => $total]);
        }

        // Crear ventas
        foreach (range(1, 8) as $index) {
            $venta = Venta::create([
                'fecha_venta' => now()->subDays(rand(1, 20)),
                'total_venta' => 0,
                'notas' => 'Venta #' . $index,
                'id_cliente' => $clientes->random()->id_cliente,
                'id_empleado' => $empleados->random()->id_empleado
            ]);

            $total = 0;
            $productosVendidos = $productos->random(rand(1, 3));
            foreach ($productosVendidos as $producto) {
                $cantidad = rand(1, 5);
                $precioUnitario = $producto->precio;
                $subtotal = $cantidad * $precioUnitario;
                $total += $subtotal;

                DetalleVenta::create([
                    'id_venta' => $venta->id_venta,
                    'id_pan' => $producto->id_pan,
                    'cantidad' => $cantidad,
                    'precio_unitario' => $precioUnitario,
                    'subtotal' => $subtotal
                ]);
            }

            $venta->update(['total_venta' => $total]);
        }
    }
}
