<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_pan';
    protected $table = 'producto';
    protected $fillable = ['nombre_pan', 'precio', 'stock_disponible', 'imagen'];

    public function materialesOcupados()
    {
        return $this->hasMany(MaterialOcupado::class, 'id_pan');
    }

    public function detalleVentas()
    {
        return $this->hasMany(DetalleVenta::class, 'id_pan');
    }

    public function materiasPrimas()
    {
        return $this->belongsToMany(MateriaPrima::class, 'material_ocupado', 'id_pan', 'id_materia_prima')
                    ->withPivot('cantidad');
    }
}
