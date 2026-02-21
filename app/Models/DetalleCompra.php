<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleCompra extends Model
{
    use HasFactory;

    protected $table = 'detalle_compra';
    protected $primaryKey = 'id_detalle';
    protected $fillable = ['id_compra', 'id_materia_prima', 'cantidad', 'precio_unitario', 'subtotal'];

    public function compra()
    {
        return $this->belongsTo(Compra::class, 'id_compra');
    }

    public function materiaPrima()
    {
        return $this->belongsTo(MateriaPrima::class, 'id_materia_prima');
    }
}
