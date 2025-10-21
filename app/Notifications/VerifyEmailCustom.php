<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\VerifyEmail as VerifyEmailNotification;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\URL;

class VerifyEmailCustom extends VerifyEmailNotification
{
    /**
     * Obtén el mail de verificación.
     */
    public function toMail($notifiable)
    {
        $verificationUrl = $this->verificationUrl($notifiable);

        return (new MailMessage)
            ->subject('Verifica tu dirección de correo')
            ->line('Haz clic en el botón para verificar tu cuenta.')
            ->action('Verificar correo', $verificationUrl)
            // También incluimos la URL en texto plano (copiable/tapable en la mayoría de clientes móviles)
            ->line($verificationUrl)
            ->line('Si no creaste esta cuenta, ignora este correo.');
    }

    /**
     * Genera la URL firmada para la verificación.
     */
    protected function verificationUrl($notifiable)
    {
        $signed = URL::temporarySignedRoute(
            'verification.verify', 
            Carbon::now()->addMinutes(60),
            [
                'id'   => $notifiable->getKey(),
                'hash' => sha1($notifiable->getEmailForVerification()),
            ]
        );

        $appUrl = rtrim(config('app.url') ?: env('APP_URL', ''), '/');
        if ($appUrl) {
            $signed = preg_replace('#^https?://[^/]+#', $appUrl, $signed);
        }

        return $signed;
    }
}
