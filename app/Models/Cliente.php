<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_cliente';
    protected $table = 'clientes';
    protected $fillable = ['nombre'];

    public function ventas()
    {
        return $this->hasMany(Venta::class, 'id_cliente');
    }
}
