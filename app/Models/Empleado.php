<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empleado extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_empleado';
    protected $table = 'empleados';
    protected $fillable = ['nombre_empleado', 'rol', 'fecha_ingreso', 'user_id'];

    public function compras()
    {
        return $this->hasMany(Compra::class, 'id_empleado');
    }

    public function ventas()
    {
        return $this->hasMany(Venta::class, 'id_empleado');
    }

    public function infoEmpleado()
    {
        return $this->hasOne(InfoEmpleado::class, 'id_empleado');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
