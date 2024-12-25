<?php
include 'conexion.php';

// Obtener los clientes registrados
$sql = "SELECT id_clientes, nombre, email, direccion FROM clientes";
$stmt = $pdo->query($sql);

// Verificar si se ha solicitado eliminar un cliente
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];

    // Verificar si el cliente tiene compras registradas
    $sql_check_compras = "SELECT COUNT(*) FROM compras WHERE cliente_id = :id";
    $stmt_check_compras = $pdo->prepare($sql_check_compras);
    $stmt_check_compras->bindParam(':id', $delete_id, PDO::PARAM_INT);
    $stmt_check_compras->execute();
    $compras_count = $stmt_check_compras->fetchColumn();

    // Si el cliente tiene compras, no se puede eliminar
    if ($compras_count > 0) {
        echo "<script>alert('No se puede eliminar este cliente porque tiene compras registradas.'); window.location.href='ver_clientes.php';</script>";
        exit();
    }

    // Eliminar el cliente si no tiene compras
    $sql_delete = "DELETE FROM clientes WHERE id_clientes = :id";
    $stmt_delete = $pdo->prepare($sql_delete);
    $stmt_delete->bindParam(':id', $delete_id, PDO::PARAM_INT);
    $stmt_delete->execute();

    // Redirigir después de eliminar
    header("Location: ver_clientes.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles_3.css">
    <link rel="stylesheet" href="btn.css">
    <title>Ver Clientes</title>
</head>
<body>

<h1>Clientes Registrados</h1>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Email</th>
            <th>Dirección</th>
            <th>Acción</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
            <tr>
                <td><?php echo htmlspecialchars($row['id_clientes']); ?></td>
                <td><?php echo htmlspecialchars($row['nombre']); ?></td>
                <td><?php echo htmlspecialchars($row['email']); ?></td>
                <td><?php echo htmlspecialchars($row['direccion']); ?></td>
                <td>
                    <!-- Botón para eliminar cliente -->
                    <a href="?delete_id=<?php echo $row['id_clientes']; ?>" onclick="return confirm('¿Estás seguro de que deseas eliminar este cliente?');" class="eliminar-btn">Eliminar</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>

<a href="index.html" class="volver-btn">Volver a inicio</a>

</body>
</html>
