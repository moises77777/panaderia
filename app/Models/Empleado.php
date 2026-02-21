<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/*
 * Empleado - Modelo para la tabla empleados
 * Representa a los trabajadores de la panadería
 * Tiene relación 1:1 con info_empleados para datos adicionales (salario, etc.)
 */
class Empleado extends Model
{
    use HasFactory;

    /* $primaryKey = llave primaria personalizada (por defecto es 'id') */
    protected $primaryKey = 'id_empleado';
    
    /* $table = nombre exacto de la tabla en la base de datos */
    protected $table = 'empleados';
    
    /* 
     * $fillable = campos que se pueden asignar masivamente
     * Se usan en Empleado::create([...]) o $empleado->update([...])
     */
    protected $fillable = ['nombre_empleado', 'rol', 'fecha_ingreso'];

    /*
     * Relación: un empleado tiene muchas compras
     * hasMany = relación uno a muchos
     * id_empleado = llave foránea en tabla compras
     */
    public function compras()
    {
        return $this->hasMany(Compra::class, 'id_empleado');
    }

    /*
     * Relación: un empleado tiene muchas ventas
     * hasMany = relación uno a muchos
     */
    public function ventas()
    {
        return $this->hasMany(Venta::class, 'id_empleado');
    }

    /*
     * Relación: un empleado tiene una infoEmpleado (salario, teléfono, etc.)
     * hasOne = relación uno a uno
     * InfoEmpleado::class = modelo relacionado
     * id_empleado = llave foránea en tabla info_empleados
     * ESTA RELACIÓN SE AGREGÓ PARA LA NUEVA TABLA info_empleados
     */
    public function infoEmpleado()
    {
        return $this->hasOne(InfoEmpleado::class, 'id_empleado');
    }
}
