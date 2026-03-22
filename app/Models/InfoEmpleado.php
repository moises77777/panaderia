<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InfoEmpleado extends Model
{
    use HasFactory;

    protected $table = 'info_empleados';
    protected $primaryKey = 'id_info';
    protected $fillable = ['id_empleado', 'salario', 'telefono', 'direccion', 'fecha_contratacion', 'estado', 'notas'];

    public function empleado()
    {
        return $this->belongsTo(Empleado::class, 'id_empleado');
    }
}
