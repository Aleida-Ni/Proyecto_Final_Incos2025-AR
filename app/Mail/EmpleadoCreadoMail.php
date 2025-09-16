<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\User;

class EmpleadoCreadoMail extends Mailable
{
    use Queueable, SerializesModels;

    public $empleado;
    public $contrasenia;

    public function __construct($empleado, $contrasenia)
    {
        $this->empleado = $empleado;
        $this->contrasenia = $contrasenia;
    }

    public function build()
    {
        return $this->subject('Tu acceso al sistema')
            ->view('emails.empleado_creado')
            ->with([
                'nombre' => $this->empleado->nombre,
                'correo' => $this->empleado->correo,
                'contrasenia' => $this->contrasenia,
            ]);
    }
}

