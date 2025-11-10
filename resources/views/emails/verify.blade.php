<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Verifica tu correo</title>
    <style>
        /* Estilos inline mínimos para compatibilidad con clientes de correo */
        /* Versión profesional: fondo blanco, acento dorado sutil en CTA */
        body { background-color:#ffffff; margin:0; padding:20px; font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial; color:#0b0b0b; }
        .container { max-width:640px; margin:0 auto; background:#ffffff; border-radius:8px; overflow:hidden; border:1px solid #ececec; }
        .header { background:transparent; color:#000; padding:18px 20px; text-align:center; border-bottom:1px solid #f3f3f3; }
        .brand { font-size:20px; font-weight:800; letter-spacing:0.4px; }
        .content { padding:26px; color:#0b0b0b; }
        h1 { margin:0 0 12px 0; font-size:20px; }
        p { margin:0 0 14px 0; line-height:1.5; }
        .btn-wrap { text-align:center; margin:22px 0; }
        /* CTA con acento dorado pero sobrio */
        .btn { background:#d4af37; color:#000; text-decoration:none; padding:12px 20px; border-radius:6px; display:inline-block; font-weight:700; border:1px solid #c49b2a; }
        .btn:hover { opacity:0.97; }
        .url { word-break:break-all; font-size:13px; color:#333; background:#ffffff; padding:10px; border-radius:6px; border:1px solid #f1f1f1; }
        .footer { background:transparent; padding:16px 28px; color:#666; font-size:13px; border-top:1px solid #f3f3f3; }
        @media (max-width:480px){ .content{padding:18px} .header{padding:14px} }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <div class="brand">Barbe Shop</div>
    </div>
    <div class="content">
    <h1>Verifica tu dirección de correo</h1>
    <p>¡Hola{{ isset($notifiable->name) ? ' ' . $notifiable->name : '' }}! Gracias por registrarte en Barbe Shop.</p>
    <p>Antes de comenzar, necesitamos confirmar que <strong>{{ $notifiable->getEmailForVerification() }}</strong> es tu correo electrónico. Pulsa el botón de abajo para verificar tu cuenta.</p>

        <div class="btn-wrap">
            <a class="btn" href="{{ $url }}" target="_blank" rel="noopener">Verificar mi correo</a>
        </div>

        <p>Si el botón no funciona, copia y pega este enlace en tu navegador:</p>
        <div class="url">{{ $url }}</div>

    <p>Si no creaste una cuenta en Barbe Shop, puedes ignorar este correo y no haremos ningún cambio.</p>
    </div>
    <div class="footer">
        <div>¿Necesitas ayuda? Responde a este correo o visita nuestro sitio web.</div>
        <div style="margin-top:8px">© {{ date('Y') }} Barbe Shop. Todos los derechos reservados.</div>
    </div>
</div>
</body>
</html>
