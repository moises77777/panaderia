<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_venta';
    protected $table = 'ventas';
    protected $fillable = ['fecha_venta', 'total_venta', 'notas', 'id_cliente', 'id_empleado'];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'id_cliente');
    }

    public function empleado()
    {
        return $this->belongsTo(Empleado::class, 'id_empleado');
    }

    public function detalles()
    {
        return $this->hasMany(DetalleVenta::class, 'id_venta');
    }

    public function productos()
    {
        return $this->belongsToMany(Producto::class, 'detalle_venta', 'id_venta', 'id_pan')
                    ->withPivot('cantidad', 'precio_unitario', 'subtotal');
    }
}
