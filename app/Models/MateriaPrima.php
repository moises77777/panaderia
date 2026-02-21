<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MateriaPrima extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_materia_prima';
    protected $table = 'materia_prima';
    protected $fillable = ['nombre_materia', 'unidad_fija', 'stock_actual', 'fecha_ingreso', 'fecha_salida'];

    public function materialesOcupados()
    {
        return $this->hasMany(MaterialOcupado::class, 'id_materia_prima');
    }

    public function detalleCompras()
    {
        return $this->hasMany(DetalleCompra::class, 'id_materia_prima');
    }

    public function productos()
    {
        return $this->belongsToMany(Producto::class, 'material_ocupado', 'id_materia_prima', 'id_pan')
                    ->withPivot('cantidad');
    }
}
