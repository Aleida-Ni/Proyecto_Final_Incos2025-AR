<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Cuenta creada</title>
</head>
<body>
    <h2>Hola {{ $nombre }},</h2>
    <p>Tu cuenta en el sistema ha sido creada.</p>
    <p>Tu correo de acceso: {{ $correo }}</p>
    <p>Tu contraseña temporal: <strong>{{ $contrasenia }}</strong></p>
    <p>Por favor cambia tu contraseña después de iniciar sesión.</p>
</body>
</html>
