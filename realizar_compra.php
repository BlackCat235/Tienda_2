<?php
include 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $cliente_id = $_POST['cliente_id'];
    $producto_id = $_POST['producto_id'];
    $cantidad = $_POST['cantidad'];

    // Verificar si el cliente existe usando 'id_clientes'
    $sql = "SELECT id_clientes FROM clientes WHERE id_clientes = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$cliente_id]);
    $cliente = $stmt->fetch();

    if (!$cliente) {

        echo '<div class="error-message">Cliente no encontrado.</div>';
        exit;  // Detenemos la ejecución si el cliente no existe
    }

    // Obtener el precio del producto y la cantidad disponible usando 'id_productos'
    $sql = "SELECT id_productos, nombre, descripcion, precio, cantidad_disponible FROM productos WHERE id_productos = ?";

        echo '<div class="success-message">Cliente no encontrado.</div>';
        exit;  // Detenemos la ejecución si el cliente no existe
    }

    // Obtener el precio del producto usando 'id_productos'
    $sql = "SELECT precio FROM productos WHERE id_productos = ?";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([$producto_id]);
    $producto = $stmt->fetch();

    if (!$producto) {

        echo '<div class="error-message">Producto no encontrado.</div>';
        exit;  // Detenemos la ejecución si el producto no existe
    }

    // Verificar si la cantidad solicitada está disponible
    if ($producto['cantidad_disponible'] < $cantidad) {
        echo '<div class="error-message">No hay suficiente cantidad disponible para realizar la compra.</div>';
        exit;

        echo '<div class="success-message">Producto no encontrado.</div>';
        exit;  // Detenemos la ejecución si el producto no existe

    }

    $precio_total = $producto['precio'] * $cantidad;

    // Registrar la compra
    $sql = "INSERT INTO compras (cliente_id, producto_id, cantidad, precio_total, fecha_compra) VALUES (?, ?, ?, ?, NOW())";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$cliente_id, $producto_id, $cantidad, $precio_total]);


    // Actualizar la cantidad disponible del producto
    $sql_update = "UPDATE productos SET cantidad_disponible = cantidad_disponible - ? WHERE id_productos = ?";
    $stmt_update = $pdo->prepare($sql_update);
    $stmt_update->execute([$cantidad, $producto_id]);



    echo '<div class="success-message">Compra realizada con éxito!</div>';
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Realizar Compra</title>
    <link rel="stylesheet" href="styles_2.css">
</head>
<body>
    <form action="realizar_compra.php" method="POST">
        <h1>Realizar Compra</h1>
        
        <label for="cliente_id">Cliente:</label><br>
        <select name="cliente_id" id="cliente_id" required>
            <?php
            // Llenar el select de clientes con 'id_clientes'
            $sql = "SELECT id_clientes, nombre FROM clientes";
            $stmt = $pdo->query($sql);
            while ($row = $stmt->fetch()) {
                echo "<option value='{$row['id_clientes']}'>{$row['nombre']}</option>";
            }
            ?>
        </select><br>

        <label for="producto_id">Producto:</label><br>
        <select name="producto_id" id="producto_id" required>
            <?php
            // Llenar el select de productos con 'id_productos'
            $sql = "SELECT id_productos, nombre FROM productos";
            $stmt = $pdo->query($sql);
            while ($row = $stmt->fetch()) {
                echo "<option value='{$row['id_productos']}'>{$row['nombre']}</option>";
            }
            ?>
        </select><br>

        <label for="cantidad">Cantidad:</label><br>
        <input type="number" name="cantidad" id="cantidad" required><br>

        <button type="submit">Realizar Compra</button>
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
