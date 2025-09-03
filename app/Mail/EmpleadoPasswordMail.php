<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\User;

class EmpleadoPasswordMail extends Mailable
{
    use Queueable, SerializesModels;

    public $empleado;
    public $password;

    public function __construct(User $empleado, $password)
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

