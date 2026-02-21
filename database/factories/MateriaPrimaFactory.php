<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class MateriaPrimaFactory extends Factory
{
    public function definition(): array
    {
        $materias = [
            'Harina', 'Levadura', 'Azúcar', 'Sal', 'Mantequilla', 
            'Huevos', 'Leche', 'Aceite', 'Canela', 'Vainilla'
        ];
        
        return [
            'nombre_materia' => $this->faker->randomElement($materias),
            'unidad_fija' => $this->faker->numberBetween(100, 1000),
            'stock_actual' => $this->faker->numberBetween(50, 500),
            'fecha_ingreso' => $this->faker->date(),
            'fecha_salida' => $this->faker->optional(0.3)->date(),
        ];
    }
}
