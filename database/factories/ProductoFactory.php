<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProductoFactory extends Factory
{
    public function definition(): array
    {
        $productos = [
            'Pan Francés', 'Pan Integral', 'Croissant', 'Baguette', 
            'Pan Dulce', 'Pan de Molde', 'Bollo', 'Pan de Centeno'
        ];
        
        return [
            'nombre_pan' => $this->faker->randomElement($productos),
            'precio' => $this->faker->randomFloat(2, 1, 50),
            'stock_disponible' => $this->faker->numberBetween(10, 100),
        ];
    }
}
