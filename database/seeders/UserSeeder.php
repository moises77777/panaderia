<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Empleado;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin user (jefe)
        $jefe = User::updateOrCreate(
            ['email' => 'admin@panaderia.com'],
            [
                'name' => 'Administrador',
                'username' => 'jefe',
                'password' => Hash::make('admin123'),
                'role' => 'jefe',
            ]
        );

        // Create empleado for jefe
        $empleadoJefe = Empleado::updateOrCreate(
            ['user_id' => $jefe->id],
            [
                'nombre_empleado' => 'Administrador',
                'rol' => 'Jefe',
                'fecha_ingreso' => now(),
            ]
        );

        // Create cashier user (cajera)
        $cajera = User::updateOrCreate(
            ['email' => 'cajera@panaderia.com'],
            [
                'name' => 'Cajera Principal',
                'username' => 'cajera',
                'password' => Hash::make('cajera123'),
                'role' => 'cajera',
            ]
        );

        // Create empleado for cajera
        Empleado::updateOrCreate(
            ['user_id' => $cajera->id],
            [
                'nombre_empleado' => 'Cajera Principal',
                'rol' => 'Cajera',
                'fecha_ingreso' => now(),
            ]
        );

        // Create additional cashier users
        $maria = User::updateOrCreate(
            ['email' => 'maria@panaderia.com'],
            [
                'name' => 'Maria Lopez',
                'username' => 'maria',
                'password' => Hash::make('cajera123'),
                'role' => 'cajera',
            ]
        );

        Empleado::updateOrCreate(
            ['user_id' => $maria->id],
            [
                'nombre_empleado' => 'Maria Lopez',
                'rol' => 'Cajera',
                'fecha_ingreso' => now(),
            ]
        );

        $ana = User::updateOrCreate(
            ['email' => 'ana@panaderia.com'],
            [
                'name' => 'Ana Martinez',
                'username' => 'ana',
                'password' => Hash::make('cajera123'),
                'role' => 'cajera',
            ]
        );

        Empleado::updateOrCreate(
            ['user_id' => $ana->id],
            [
                'nombre_empleado' => 'Ana Martinez',
                'rol' => 'Cajera',
                'fecha_ingreso' => now(),
            ]
        );
    }
}
