<?php
include 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $direccion = $_POST['direccion'];

    $sql = "INSERT INTO clientes (nombre, email, direccion) VALUES (?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$nombre, $email, $direccion]);

    echo '<div class="success-message">Cliente registrado con éxito!</div>';
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles_2.css">
    <title>Registrar Cliente</title>
</head>
<body>
    
    <form action="registro_cliente.php" method="POST">
        <h1>Registrar Cliente</h1>
        <label for="nombre">Nombre:</label><br>
        <input type="text" name="nombre" id="nombre" required><br>
        <label for="email">Email:</label><br>
        <input type="email" name="email" id="email" required><br>
        <label for="direccion">Dirección:</label><br>
        <input type="text" name="direccion" id="direccion" required><br>
        <button type="submit">Registrar</button>
        <a href="index.html" class="volver-btn">Volver a inicio</a>    
    </form>
    <script>
    // Espera 5 segundos para ocultar el mensaje
    setTimeout(function() {
        var message = document.querySelector('.success-message');
        if (message) {
            message.style.opacity = 0;  // Desvanecer el mensaje
            setTimeout(function() {
                message.remove(); // Eliminar el mensaje completamente
            }, 1000); // Esperar a que la animación de desaparición termine
        }
    }, 5000); // 5000 milisegundos = 5 segundos
</script>
</body>
</html>
