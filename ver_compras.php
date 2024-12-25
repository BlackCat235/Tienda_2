<?php
include 'conexion.php';

// Verificar si se ha solicitado eliminar una compra
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];

    // Eliminar la compra de la base de datos
    $sql_delete = "DELETE FROM compras WHERE id_compras = :id";
    $stmt_delete = $pdo->prepare($sql_delete);
    $stmt_delete->bindParam(':id', $delete_id, PDO::PARAM_INT);
    $stmt_delete->execute();

    // Redirigir a la página de compras después de eliminar
    header("Location: ver_compras.php");
    exit();
}

// Obtener las compras realizadas
$sql = "SELECT c.id_compras, cl.nombre AS cliente_nombre, p.nombre AS producto_nombre, 
               c.cantidad, c.precio_total, c.fecha_compra 
        FROM compras c
        JOIN clientes cl ON c.cliente_id = cl.id_clientes
        JOIN productos p ON c.producto_id = p.id_productos";

$stmt = $pdo->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles_3.css">
    <link rel="stylesheet" href="btn.css">
    <title>Ver Compras</title>
</head>
<body>

<h1>Compras Realizadas</h1>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Cliente</th>
            <th>Producto</th>
            <th>Cantidad</th>
            <th>Precio Total</th>
            <th>Fecha de Compra</th>
            <th>Acción</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
            <tr>
                <td><?php echo htmlspecialchars($row['id_compras']); ?></td>
                <td><?php echo htmlspecialchars($row['cliente_nombre']); ?></td>
                <td><?php echo htmlspecialchars($row['producto_nombre']); ?></td>
                <td><?php echo htmlspecialchars($row['cantidad']); ?></td>
                <td><?php echo htmlspecialchars($row['precio_total']); ?></td>
                <td><?php echo htmlspecialchars($row['fecha_compra']); ?></td>
                <td>
                    <!-- Botón para eliminar compra -->
                    <a href="?delete_id=<?php echo $row['id_compras']; ?>" onclick="return confirm('¿Estás seguro de que deseas eliminar esta compra?');" class="eliminar-btn">Eliminar</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>

<a href="index.html" class="volver-btn">Volver a inicio</a>

</body>
</html>

