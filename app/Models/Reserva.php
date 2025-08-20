<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reserva extends Model
{
    use HasFactory;
        protected $fillable = ['user_id', 'barbero_id', 'fecha', 'hora','estado'];
        const CREATED_AT = 'creado_en';
const UPDATED_AT = 'actualizado_en';


    public function cliente()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function barbero()
    {
        return $this->belongsTo(Barbero::class);
    }


// app/Models/Reserva.php
public function usuario() {
    return $this->belongsTo(User::class);
}



}
