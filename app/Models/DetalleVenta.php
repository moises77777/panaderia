<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleVenta extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_detalle_venta';
    protected $table = 'detalle_venta';
    protected $fillable = ['id_venta', 'id_pan', 'cantidad', 'precio_unitario', 'subtotal'];

    public function venta()
    {
        return $this->belongsTo(Venta::class, 'id_venta');
    }

    public function producto()
    {
        return $this->belongsTo(Producto::class, 'id_pan');
    }
}
