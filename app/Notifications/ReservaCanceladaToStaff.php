<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\DatabaseMessage;
use App\Models\Reserva;

class ReservaCanceladaToStaff extends Notification
{
    use Queueable;

    protected $reserva;

    public function __construct(Reserva $reserva)
    {
        $this->reserva = $reserva;
    }

    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        $barberoName = $this->reserva->barbero->nombre ?? 'Sin asignar';

        return (new MailMessage)
            ->subject('Reserva cancelada — ID '.$this->reserva->id)
            ->greeting('Hola')
            ->line('La siguiente reserva ha sido cancelada por el cliente:')
            ->line('ID: '.$this->reserva->id)
            ->line('Barbero: '.$barberoName)
            ->line('Fecha: '.$this->reserva->fecha)
            ->line('Hora: '.$this->reserva->hora)
            ->action('Ver reservas', url(route('admin.reservas.index')))
            ->line('Si no esperabas esto, revisa la reserva en el panel de administración.');
    }

    public function toDatabase($notifiable)
    {
        return [
            'reserva_id' => $this->reserva->id,
            'barbero' => $this->reserva->barbero->nombre ?? null,
            'fecha' => $this->reserva->fecha,
            'hora' => $this->reserva->hora,
            'mensaje' => 'Reserva cancelada por cliente',
        ];
    }
}
