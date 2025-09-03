<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Bienvenido</title>
</head>
<body>
    <h2>Hola {{ $empleado->nombre }}</h2>
    <p>Has sido registrado como empleado en la Barbería.</p>
    <p>Tu usuario es: <strong>{{ $empleado->email }}</strong></p>
    <p>Tu contraseña temporal es: <strong>{{ $password }}</strong></p>
    <p>Por favor, inicia sesión y cámbiala lo antes posible.</p>
</body>
</html>
