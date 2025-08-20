<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    protected $fillable = ['cliente_id', 'empleado_id', 'codigo', 'total'];

    // app/Models/Venta.php
public function detalles()
{
    return $this->hasMany(DetalleVenta::class, 'venta_id');
}



    public function cliente()
    {
        return $this->belongsTo(User::class, 'cliente_id');
    }

    public function empleado()
    {
        return $this->belongsTo(User::class, 'empleado_id');
    }
}


