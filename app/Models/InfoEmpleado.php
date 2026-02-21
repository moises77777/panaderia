<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/*
 * InfoEmpleado - Modelo para la tabla info_empleados
 * Guarda información adicional de empleados: salario, teléfono, dirección, etc.
 * Relación 1:1 con tabla empleados
 */
class InfoEmpleado extends Model
{
    use HasFactory;

    /* $table = nombre exacto de la tabla en la base de datos */
    protected $table = 'info_empleados';
    
    /* $primaryKey = nombre de la llave primaria (por defecto es 'id') */
    protected $primaryKey = 'id_info';
    
    /* 
     * $fillable = campos que se pueden asignar masivamente (mass assignment)
     * Estos campos se pueden llenar con Empleado::create([...])
     */
    protected $fillable = ['id_empleado', 'salario', 'telefono', 'direccion', 'fecha_contratacion', 'estado', 'notas'];

    /*
     * Relación: infoEmpleado pertenece a un empleado
     * belongsTo = relación inversa (muchos a uno)
     * id_empleado = llave foránea que conecta con tabla empleados
     */
    public function empleado()
    {
        return $this->belongsTo(Empleado::class, 'id_empleado');
    }
}
