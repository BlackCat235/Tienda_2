<?php
include 'conexion.php';

// Verificar si se ha solicitado eliminar un producto
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];

    // Eliminar el producto de la base de datos
    $sql_delete = "DELETE FROM productos WHERE id_productos = :id";
    $stmt_delete = $pdo->prepare($sql_delete);
    $stmt_delete->bindParam(':id', $delete_id, PDO::PARAM_INT);
    $stmt_delete->execute();

    // Redirigir a la página de productos después de eliminar
    header("Location: ver_productos.php");
    exit();
}

// Obtener los productos registrados (incluyendo cantidad disponible)
$sql = "SELECT id_productos, nombre, descripcion, precio, cantidad_disponible FROM productos";
$stmt = $pdo->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles_3.css">
    <link rel="stylesheet" href="btn.css">
    <title>Ver Productos</title>
</head>
<body>

<h1>Productos Registrados</h1>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Descripción</th>
            <th>Precio</th>
            <th>Cantidad Disponible</th> <!-- Nueva columna para cantidad disponible -->
            <th>Acción</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
            <tr>
                <td><?php echo htmlspecialchars($row['id_productos']); ?></td>
                <td><?php echo htmlspecialchars($row['nombre']); ?></td>
                <td><?php echo htmlspecialchars($row['descripcion']); ?></td>
                <td><?php echo htmlspecialchars($row['precio']); ?></td>
                <td><?php echo htmlspecialchars($row['cantidad_disponible']); ?></td> <!-- Mostrar cantidad disponible -->
                <td>
                    <!-- Botón para eliminar producto -->
                    <a href="?delete_id=<?php echo $row['id_productos']; ?>" onclick="return confirm('¿Estás seguro de que deseas eliminar este producto?');" class="eliminar-btn">Eliminar</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>

<a href="index.html" class="volver-btn">Volver a inicio</a>

</body>
</html>
