<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaterialOcupado extends Model
{
    use HasFactory;

    protected $table = 'material_ocupado';
    protected $primaryKey = 'id_material';
    protected $fillable = ['id_pan', 'id_materia_prima', 'cantidad'];

    public function producto()
    {
        return $this->belongsTo(Producto::class, 'id_pan');
    }

    public function materiaPrima()
    {
        return $this->belongsTo(MateriaPrima::class, 'id_materia_prima');
    }
}
