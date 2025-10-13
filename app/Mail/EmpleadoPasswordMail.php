<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Usuario;

class EmpleadoPasswordMail extends Mailable
{
    use Queueable, SerializesModels;

    public $empleado;
    public $password;

    public function __construct(Usuario $empleado, $password)
    {
        $this->empleado = $empleado;
        $this->password = $password;
    }

    public function build()
    {
        return $this->subject('Bienvenido a la Barbería')
            ->view('emails.empleado_password');
    }
}

