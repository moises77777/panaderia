<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Compra extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_compra';
    protected $table = 'compras';
    protected $fillable = ['fecha_compra', 'total_compra', 'notas', 'id_empleado'];

    public function empleado()
    {
        return $this->belongsTo(Empleado::class, 'id_empleado');
    }

    public function detalles()
    {
        return $this->hasMany(DetalleCompra::class, 'id_compra');
    }

    public function materiasPrimas()
    {
        return $this->belongsToMany(MateriaPrima::class, 'detalle_compra', 'id_compra', 'id_materia_prima')
                    ->withPivot('cantidad', 'precio_unitario', 'subtotal');
    }
}
