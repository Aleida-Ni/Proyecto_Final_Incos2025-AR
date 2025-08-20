<?php

// app/Models/DetalleVenta.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DetalleVenta extends Model
{
    use HasFactory;

    protected $table = 'detalles_venta';
    public $timestamps = false;

    protected $fillable = [
        'venta_id',
        'producto_id',
        'cantidad',
        'precio',
        'subtotal'
    ];


    const CREATED_AT = 'creado_en';
    const UPDATED_AT = 'actualizado_en';

    public function venta() {
        return $this->belongsTo(Venta::class);
    }


    // app/Models/DetalleVenta.php
public function producto()
{
    return $this->belongsTo(Producto::class, 'producto_id');
}

}



