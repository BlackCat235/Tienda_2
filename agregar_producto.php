<?php
include 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $precio = $_POST['precio'];
    $cantidad_disponible = $_POST['cantidad_disponible']; // Obtener la cantidad disponible

    // Insertar el producto en la base de datos, incluyendo la cantidad disponible
    $sql = "INSERT INTO productos (nombre, descripcion, precio, cantidad_disponible) VALUES (?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$nombre, $descripcion, $precio, $cantidad_disponible]);

    echo '<div class="success-message">Producto agregado con éxito!</div>';
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Producto</title>
    <link rel="stylesheet" href="styles_2.css">
</head>
<body>
    <form action="agregar_producto.php" method="POST">
        <h1>Agregar Producto</h1>
        
        <label for="nombre">Nombre del Producto:</label><br>
        <input type="text" name="nombre" id="nombre" required><br>
        
        <label for="descripcion">Descripción:</label><br>
        <textarea name="descripcion" id="descripcion" required></textarea><br>
        
        <label for="precio">Precio:</label><br>
        <input type="number" name="precio" id="precio" step="0.01" required><br>
        
        <label for="cantidad_disponible">Cantidad Disponible:</label><br>
        <input type="number" name="cantidad_disponible" id="cantidad_disponible" required><br>

        <button type="submit">Agregar Producto</button>
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
