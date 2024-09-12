<?php
include 'db.php';

// Consulta para obtener las órdenes junto con los nombres de los productos
$query = "
    SELECT o.id_orden, o.fecha, o.total, o.estado, 
           GROUP_CONCAT(a.nombre SEPARATOR ', ') AS productos
    FROM ordenes o
    JOIN detalles_orden do ON o.id_orden = do.id_orden
    JOIN articulos a ON do.id_articulo = a.id_articulo
    GROUP BY o.id_orden
";

$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Administrar Órdenes</title>
    <link rel="stylesheet" href="../css/adminPEDIDOS.css"> <!-- Tu CSS para Admin -->
</head>
<body>
    <h1>Órdenes Realizadas</h1>
    <table border="1">
        <thead>
            <tr>
                <th>ID Orden</th>
                <th>Fecha</th>
                <th>Total</th>
                <th>Estado</th>
                <th>Productos</th> <!-- Nueva columna para productos -->
                <th>Acciones</th> <!-- Nueva columna para acciones -->
            </tr>
        </thead>
        <tbody>
            <?php while ($orden = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= $orden['id_orden']; ?></td>
                    <td><?= $orden['fecha']; ?></td>
                    <td>$<?= number_format($orden['total'], 2); ?></td>
                    <td><?= $orden['estado']; ?></td>
                    <td><?= $orden['productos']; ?></td> <!-- Mostrar productos aquí -->
                    <td>
                        <form method="post" action="eleccion.php">
                            <input type="hidden" name="id_orden" value="<?= $orden['id_orden']; ?>">
                            <button type="submit" name="accion" value="aceptar">Aceptar</button>
                            <button type="submit" name="accion" value="rechazar">Rechazar</button>
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</body>
</html>
