<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class EmpleadoFactory extends Factory
{
    public function definition(): array
    {
        return [
            'nombre_empleado' => $this->faker->name(),
            'rol' => $this->faker->randomElement(['Panadero', 'Cajero', 'Gerente', 'Ayudante']),
            'fecha_ingreso' => $this->faker->date(),
        ];
    }
}
